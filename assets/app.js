// Import du fichier SCSS
require('./scss/main.scss')

import 'bootstrap'

import tinymce from 'tinymce'
require ('tinymce/themes/silver/index')
require ('tinymce/models/dom/index')
require ('tinymce/icons/default/index')

require('tinymce/skins/content/default/content')
require('tinymce/skins/ui/oxide/content')
require('tinymce/skins/ui/oxide/skin')

tinymce.init({
    selector: 'textarea.wysiwyg',
})