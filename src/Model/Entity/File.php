<?php

namespace Apps\Model\Entity;

use Cake\Cache\Cache;
use Cake\ORM\Entity;

/**
 * File Entity
 *
 * @property int $id
 * @property string $src
 * @property string $path
 * @property int|null $mime_type_id
 * @property string $name
 * @property int $size
 * @property int|null $width
 * @property int|null $height
 * @property int|null $user_id
 * @property \Cake\I18n\FrozenTime $date_created
 * @property \Cake\I18n\FrozenTime $date_accessed
 *
 * @property \Apps\Model\Entity\MimeType $mime_type
 * @property \Apps\Model\Entity\MimeType[] $mime_types
 * @property \Apps\Model\Entity\User $user
 * @property \Apps\Model\Entity\AppLink[] $app_links
 */
class File extends Entity
{

    private $imagepng = 13; // TODO is is an ugly solution; we should find the key for "image/png" in the database

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'src' => true,
        'path' => true,
        'mime_type_id' => true,
        'name' => true,
        'size' => true,
        'width' => true,
        'height' => true,
        'user_id' => true,
        'date_created' => true,
        'date_accessed' => true,
        'mime_types' => true,
        'user' => true,
        'app_links' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'id'
    ];

    /**
     * Fields that can be filtered.
     *
     * @var array
     */
    public static $filterable = [
        'name',
        'mime_type' => 'name',
        'user' => 'display_name',
    ];

    /**
     * The priority of the fields, unspecified fields have the highest priority. Add fields to this list
     * in order of priority from high to low.
     *
     * @var array
     */
    //public static $priority = [];

    public function generateHash()
    {
        if ($this->hash === false) {
            $this->hash = md5($this->src . $this->path . $this->mime_type_id . $this->name . $this->size . $this->width . $this->height);
        }
        return $this->hash;
    }

    // fetches and returns the content body of the file
    public function content($drivecomponent, $width = false, $height = false)
    {

        // if there's no cloud drive assume this file is local
        if ($drivecomponent === false) {
            if (is_readable($this->path)) {
                return file_get_contents($this->path);
            }
            return false;
        }

        // cloud drive; check local cache for the file
        $cachekey = $this->src . "_" . $this->path . "_" . strtotime($this->date_created) . "_" . $this->generateHash();
        if ($width === false && $height === false) {
            $cachecfg = "files";
        } else {
            $cachekey .= "_" . (int)$width . "x" . (int)$height;
            $cachecfg = "resized";
        }

        $content = Cache::read($cachekey, $cachecfg);
        if ($content === false) {
            // not found go out to cloud drive
            $f = $drivecomponent->getFile($this->path);
            $content = $f['content'];
            if ($this->mime_type->resize == 'yes' && ($width || $height)) {
                $content = $this->resize($content, $width, $height);
            }
            if (!empty($content)) {
                Cache::write($cachekey, $content, $cachecfg);
            }
        }

        return $content;

    }

    private function resize($content, $new_width = false, $new_height = false)
    {

        if (($source_image = imagecreatefromstring($content)) === false) {
            return false;
        }

        // calculate our target width and height
        $source_width = imagesx($source_image);
        $source_height = imagesy($source_image);
        $source_ratio = $source_height / $source_width;
        $new_ratio = $new_height / $new_width;

        $w = [$source_width];
        if ($new_width) {
            $w[] = $new_width;
        }
        $w = (int)min($w);

        $h = [$source_height];
        if ($new_height) {
            $h[] = $new_height;
        }
        $h = (int)min($h);

        if (empty($w) || empty($h)) {
            return false;
        }

        if ($source_ratio > $new_ratio) {
            $h = round($w * $source_ratio);
        } else {
            $w = round($h * ($source_width / $source_height));
        }

        // create new image and re-size
        $new_image = imagecreatetruecolor($w, $h);
        imagealphablending($new_image, false);
        imagesavealpha($new_image, true);

        $white_transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
        imagefill($new_image, 0, 0, $white_transparent);
        imagecopyresampled($new_image, $source_image, 0, 0, 0, 0, $w, $h, $source_width, $source_height);

        ob_start();
        imagepng($new_image, null, 9);
        $content = ob_get_clean();
        imagedestroy($source_image);
        imagedestroy($new_image);

        $this->mime_type_id = $this->imagepng; // the ID for the mime_type table entry for image/png
        $this->mime_type->name = "image/png";

        return $content;

    }

}
