<?php
	ini_set('default_mimetype', 'text/css');
	
	$color1 = "#fffcf5";				// fondo pie (mas claro)
	$color2 = "#f9e6c1";				// fondo cabecera, borde, menu activo (mas oscuro)
	$color3 = "#808080";				// texto paginacion
	$color4 = "#f5d89b";				// borde campos, seleccion fila
	$color5 = "#FFFFFF";				// fondo degradado para color1
	$color6 = "#2d4686";				// texto usuario logueado	
?>

/* FILA SELECCIONADA */

.fila:hover {
	background-color: <?=$color4?>!important;
}

/* PERSONALIZACION BOOTSTRAP */

.navbar-default {
	background-color: <?=$color1?>;
	border-color: <?=$color2?>;
}

.navbar-default .navbar-nav > .active > a:focus {
	background-color: <?=$color2?>;
}

.navbar-default .navbar-form {
	border-color: <?=$color2?>;
}

.navbar-default .navbar-nav > .open > a:focus {
	background-color: <?=$color2?>;
}

.navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus {
	background-color: <?=$color2?>;
}

.usuario {
	padding: 5px 5px 2px 0px;
	font-style: italic;
	font-size: 12px;
	color: <?=$color6?>;
}

mark,                             // PENDIENTE
.mark {
	background-color: #fcf8e3;
}

.dropdown-menu > li > a:focus {
	background-image: -webkit-linear-gradient(top, <?=$color1?> 0%, <?=$color2?> 100%);
	background-image:      -o-linear-gradient(top, <?=$color1?> 0%, <?=$color2?> 100%);
	background-image: -webkit-gradient(linear, left top, left bottom, from(<?=$color1?>), to(<?=$color2?>));
	background-image:         linear-gradient(to bottom, <?=$color1?> 0%, <?=$color2?> 100%);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff<?=substr($color1,1,6)?>', endColorstr='#ff<?=substr($color2,1,6)?>', GradientType=0);
}

.progress {
	background-image: -webkit-linear-gradient(top, <?=$color2?> 0%, <?=$color1?> 100%);
	background-image:      -o-linear-gradient(top, <?=$color2?> 0%, <?=$color1?> 100%);
	background-image: -webkit-gradient(linear, left top, left bottom, from(<?=$color2?>), to(<?=$color1?>));
	background-image:         linear-gradient(to bottom, <?=$color2?> 0%, <?=$color1?> 100%);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffebebeb', endColorstr='#ff<?=substr($color1,1,6)?>', GradientType=0);
	background-color: <?=$color1?>;
}

.panel-default > .panel-heading {
	background-image: -webkit-linear-gradient(top, <?=$color1?> 0%, <?=$color2?> 100%);
	background-image:      -o-linear-gradient(top, <?=$color1?> 0%, <?=$color2?> 100%);
	background-image: -webkit-gradient(linear, left top, left bottom, from(<?=$color1?>), to(<?=$color2?>));
	background-image:         linear-gradient(to bottom, <?=$color1?> 0%, <?=$color2?> 100%);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff<?=substr($color1,1,6)?>', endColorstr='#ff<?=substr($color2,1,6)?>', GradientType=0);
	background-color: <?=$color1?>;
}

.well {
	background-image: -webkit-linear-gradient(top, <?=$color1?> 0%, <?=$color5?> 100%);
	background-image:      -o-linear-gradient(top, <?=$color1?> 0%, <?=$color5?> 100%);
	background-image: -webkit-gradient(linear, left top, left bottom, from(<?=$color1?>), to(<?=$color5?>));
	background-image:         linear-gradient(to bottom, <?=$color1?> 0%, <?=$color5?> 100%);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff<?=substr($color1,1,6)?>', endColorstr='#ff<?=substr($color5,1,6)?>', GradientType=0);
	background-color: <?=$color5?>;
}

pre {
	background-color: <?=$color1?>;
}

.table-striped > tbody > tr:nth-of-type(odd) {
	background-color: <?=$color1?>;
}

.table-hover > tbody > tr:hover {
	background-color: <?=$color1?>;
}

.table > thead > tr > td.active,
.table > tbody > tr > td.active,
.table > tfoot > tr > td.active,
.table > thead > tr > th.active,
.table > tbody > tr > th.active,
.table > tfoot > tr > th.active,
.table > thead > tr.active > td,
.table > tbody > tr.active > td,
.table > tfoot > tr.active > td,
.table > thead > tr.active > th,
.table > tbody > tr.active > th,
.table > tfoot > tr.active > th {
	background-color: <?=$color1?>;
}

.dropdown-menu > li > a:focus {
	background-color: <?=$color1?>;
}

.breadcrumb {
	background-color: <?=$color1?>;
} 

button.list-group-item:focus {
	background-color: <?=$color1?>;
}

.panel-footer {
	background-color: <?=$color1?>;
}

.panel-default > .panel-heading .badge {
	color: <?=$color1?>;
}

.navbar-default .navbar-nav > .active > a,
.navbar-default .navbar-nav > .active > a:hover,
.navbar-default .navbar-nav > .active > a:focus {
	background-color: <?=$color2?>;
}

.navbar-default .navbar-collapse,
.navbar-default .navbar-form {
	border-color: <?=$color2?>;
}

.navbar-default .navbar-nav > .open > a,
.navbar-default .navbar-nav > .open > a:hover,
.navbar-default .navbar-nav > .open > a:focus {
	background-color: <?=$color2?>;
}

.navbar-default .navbar-toggle {
	border-color: <?=$color2?>;
}

.navbar-inverse .navbar-brand {
	color: <?=$color2?>;
}

.pagination > li > a:hover,
.pagination > li > span:hover,
.pagination > li > a:focus,
.pagination > li > span:focus {
	color: <?=$color3?>;
	background-color: <?=$color1?>;
	border-color: <?=$color2?>;
}

.table > thead > tr > th,
.table > tbody > tr > th,
.table > tfoot > tr > th,
.table > thead > tr > td,
.table > tbody > tr > td,
.table > tfoot > tr > td {
	border-top: 1px solid <?=$color2?>;
}

.table > thead > tr > th {
	border-bottom: 2px solid <?=$color2?>;
}

.table > tbody + tbody {
	border-top: 2px solid <?=$color2?>;
}

.table-bordered {
	border: 1px solid <?=$color2?>;
}

.table-striped > tbody > tr:nth-of-type(odd) {
	background-color: <?=$color1?>;
}

.table-hover > tbody > tr:hover {
	background-color: <?=$color2?>;
}

@media screen and (max-width: 767px) {
	.table-responsive {
		border: 1px solid <?=$color2?>;
	}
}

.nav-tabs {
	border-bottom: 1px solid <?=$color2?>;
}

.nav-tabs > li > a:hover {
	border-color: <?=$color1?> <?=$color1?> <?=$color2?>;
}

.nav-tabs > li.active > a,
.nav-tabs > li.active > a:hover,
.nav-tabs > li.active > a:focus {
	border: 1px solid <?=$color2?>;
}

.nav-tabs.nav-justified > .active > a,
.nav-tabs.nav-justified > .active > a:hover,
.nav-tabs.nav-justified > .active > a:focus {
	border: 1px solid <?=$color2?>;
}

@media (min-width: 768px) {
	.nav-tabs.nav-justified > li > a {
		border-bottom: 1px solid <?=$color2?>;
		border-radius: 4px 4px 0 0;
	}
	.nav-tabs-justified > .active > a,
	.nav-tabs-justified > .active > a:hover,
	.nav-tabs-justified > .active > a:focus {
		border: 1px solid <?=$color2?>;
	}
} 

.navbar-default .navbar-toggle {
	border-color: <?=$color2?>;
}

.navbar-default .navbar-toggle:hover,
.navbar-default .navbar-toggle:focus {
	background-color: <?=$color2?>;
}

.pagination > li > a,
.pagination > li > span {
	color: <?=$color3?>;
	background-color: #fff;
	border: 1px solid <?=$color2?>;
}

.pagination > li > a:hover,
.pagination > li > span:hover,
.pagination > li > a:focus,
.pagination > li > span:focus {
	color: <?=$color3?>;
	background-color: <?=$color1?>;
	border-color: <?=$color2?>;
}
.pagination > .disabled > span,
.pagination > .disabled > span:hover,
.pagination > .disabled > span:focus,
.pagination > .disabled > a,
.pagination > .disabled > a:hover,
.pagination > .disabled > a:focus {
	border-color: <?=$color2?>;
}

.pager li > span {
	border: 1px solid <?=$color2?>;
	border-radius: 15px;
}

.thumbnail {
	border: 1px solid <?=$color2?>;
}

.list-group-item {
	border: 1px solid <?=$color2?>;
}

.panel-footer {
	background-color: <?=$color1?>;
	border-top: 1px solid <?=$color2?>;
}

.panel > .panel-body + .table,
.panel > .panel-body + .table-responsive,
.panel > .table + .panel-body,
.panel > .table-responsive + .panel-body {
	border-top: 1px solid <?=$color2?>;
}

.panel-group .panel-heading + .panel-collapse > .panel-body,
.panel-group .panel-heading + .panel-collapse > .list-group {
	border-top: 1px solid <?=$color2?>;
}

.panel-group .panel-footer + .panel-collapse .panel-body {
	border-bottom: 1px solid <?=$color2?>;
}

.panel-default {
	border-color: <?=$color2?>;
}

.panel-default > .panel-heading {
	background-color: <?=$color1?>;
	border-color: <?=$color2?>;
}

.panel-default > .panel-heading + .panel-collapse > .panel-body {
	border-top-color: <?=$color2?>;
}

.panel-default > .panel-footer + .panel-collapse > .panel-body {
	border-bottom-color: <?=$color2?>;
}

.form-control {
	border: 1px solid <?=$color4?>;
}

.dropdown-menu {
	border: 1px solid <?=$color4?>;
}

.input-group-addon {
	border: 1px solid <?=$color4?>;
}

.navbar-default .navbar-nav > .disabled > a,
.navbar-default .navbar-nav > .disabled > a:hover,
.navbar-default .navbar-nav > .disabled > a:focus {
  color: <?=$color4?>;
}

@media (max-width: 767px) {
	.navbar-default .navbar-nav .open .dropdown-menu > .disabled > a,
	.navbar-default .navbar-nav .open .dropdown-menu > .disabled > a:hover,
	.navbar-default .navbar-nav .open .dropdown-menu > .disabled > a:focus {
		color: <?=$color4?>;
	}
}

.input-group-addon {
	background-color: <?=$color2?>;
	color: <?=$color3?>;
}