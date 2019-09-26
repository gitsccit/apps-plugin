<?php

return [
    'inputContainer' => '{{content}}',
    'label' => '<label{{attrs}}>{{text}}:</label>',
    'input' => '<input type="{{type}}" class="edit-name-input" name="{{name}}" {{attrs}}/>',
    'hidden' => '<input type="hidden" name="{{name}}" {{attrs}}/>',
    'dateWidget' => '<div class="form-group">{{month}}{{day}}{{year}}</div>',
    'inputSubmit' => '<input type="{{type}}"{{attrs}} />',
    'submitContainer' => '<div class="submit">{{content}}</div>',
    'error' => '<div class="alert alert-danger"> <i id="fa-danger" class="fa fa-exclamation-circle"></i> {{content}}</div>',
    'select' => '<select class="custom-select" name="{{name}}"{{attrs}}>{{content}}</select>',
    'option' => '<option  value="{{value}}"{{attrs}}>{{text}}</option>',
    'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
    'radioWrapper' => '{{label}}',
    'sort' => '<a href="{{url}}">{{text}}<span class="icon-sort"></span></a>',
    'sortAsc' => '<a href="{{url}}" class="asc">{{text}}<span class="icon-sort-down"></span></a>',
    'sortDesc' => '<a href="{{url}}" class="desc">{{text}}<span class="icon-sort-up"></span></a>',
];
