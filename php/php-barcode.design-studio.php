<!DOCTYPE html>
<html lang="en">
<title>BarCode Coder Library -> Barcode Design Studio</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no">
<link href="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAVlpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IlhNUCBDb3JlIDUuNC4wIj4KICAgPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICAgICAgPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIKICAgICAgICAgICAgeG1sbnM6dGlmZj0iaHR0cDovL25zLmFkb2JlLmNvbS90aWZmLzEuMC8iPgogICAgICAgICA8dGlmZjpPcmllbnRhdGlvbj4xPC90aWZmOk9yaWVudGF0aW9uPgogICAgICA8L3JkZjpEZXNjcmlwdGlvbj4KICAgPC9yZGY6UkRGPgo8L3g6eG1wbWV0YT4KTMInWQAAAvlJREFUWAm1lTuLVEEQhXd9rKIIRhoo6Ao+MDEwMREE0cTIxEgEMfc/bGRoYGpkJGZiJP4GQRHRyAdoZiAGKr7Pd7u/oXe4c2fcmT1wuruqq05V9713ZmlpY1juSevz9YTN77LQ1kjdq2QN3CvWJo3bqu6NzH8rWQP3irUJoyfcHu2XoQ2wxgeMKdaCR094PboU/1XJGh8wplgLHD0ZBV6EFP1dyRqfxY2Na3FQ/FokPT1zu2YPGFusBYyeiLf9eUhRTm8Drtmb+4ugGNxSxTjNzhBcDdsT20DrIwaQQy4NoaVuluvBBoGQwCE8yybFPHHbgD5ihkAN6y1TfBwE7AoPhEcqD2Y+HV4IKdqXF/do70nWT8MP4ZvKj5m/hn/CERDaHV4JT4SHwtXwcLg3XAlbDBU3ri/mRzY/h+/Ct+H78HX4IFxaC0nqI93yrSPA3BfT52tz0OiLwbfGs+CqgMXwLXeeMvMS+WZX99RpPIdigJnmqMGjtnb3COzyf05qzqxzq81j7+DpLsdSqA3UN+/calILWLu7EhyXQj+nNmFRxdGmBuAxrIOOi/Hy0lF0EU2ogSbawFrFakY3zsX3LaQJb2Qjt2AuWudCYI1i9Yz+r5/N3qeQwkOf0qTGzEEDLaB2sQbGHXXvVmYK/KzzpGJ9fnPQAGoWq458i30gGayWafS7UM2ZJn9L1FBzXXJfAyRyfXwiJ2u0YtWcaTIHDbTQ1DcoYNC+RH0JuV6fZ99VT/KZgwZaQO1iZZx0AwQcC/ewmAAK85b7pk8I6zTQAjM1YFPHS05XoE2kMN82Pq4WsvZ7z7IDPpoDaqldvBmHvkmTKCgoQg78Ht4Jwc3Qt9wY/OaqhW8qPO3DRHpaT6d9N3tHGyXW+MbjtNECaherZzRgJXuvQgsyw/vhqVB4G9rsEWO8DaCFJrBGscZGN/fH71uM2KPwTBPLc2+fJ2t8glhybAQtNIE1ijUw3s7e4/B8EzNeuNnqluONkIsGWnNhXHia2LRGR/n/ALNkVj/jnaViAAAAAElFTkSuQmCC" rel="icon" type="image/x-icon">
<style type="text/css" media="all">
/*---------------------------------------------------------------------------*/
/* STANDARD CSS
/*---------------------------------------------------------------------------*/

    *
    {
        margin:0;
        padding:0;
    }
    body
    {
        padding-left:160px;
        padding-bottom:20px;
        background:#999999;
        font-family:monospace;
    }

/*---------------------------------------------------------------------------*/
/* INPUT
/*---------------------------------------------------------------------------*/

    .INPUT_TEXT
    {
        overflow-x:hidden;
        overflow-y:hidden;
        resize:none;
        display:block;
        width:100%;
        height:20px;
        margin:0;
        padding:0;
        line-height:100%;
        background:white;
        border:0;
        border-spacing:0;
        outline:medium none;
        word-wrap:break-word;
        letter-spacing:normal;
        font-family:monospace;
        font-size:100%;
        font-weight:normal;
        text-align:left;
        text-decoration:none;
        text-indent:0;
        -webkit-appearance:none;
        -webkit-box-shadow:none;
        -moz-box-shadow:none;
        box-shadow:none;
        -webkit-box-sizing:border-box;
        -moz-box-sizing:border-box;
        -webkit-border-radius:0;
        border-radius:0;
    }
    .INPUT_BUTTON
    {
        cursor:pointer;
        display:inline-block;
        vertical-align:top;
        width:100%;
        margin:0;
        padding:10px;
        line-height:100%;
        background:white;
        border:1px solid black;
        border-spacing:0;
        word-wrap:break-word;
        white-space:normal;
        letter-spacing:normal;
        font-family:monospace;
        font-size:100%;
        font-weight:normal;
        text-align:left;
        text-decoration:underline;
        color:black;
        -webkit-appearance:none;
        -webkit-box-shadow:none;
        -moz-box-shadow:none;
        box-shadow:none;
        -webkit-box-sizing:border-box;
        -moz-box-sizing:border-box;
        -webkit-border-radius:0;
        border-radius:0;
    }
    .INPUT_BUTTON:hover
    {
        text-decoration:none;
    }
    input:required:invalid,
    input:focus:invalid,
    textarea:required:invalid,
    textarea:focus:invalid
    {
        padding-left:20px;
        background-image:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAYAAABWdVznAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAT1JREFUeNpi/P//PwMpgImBRMACY/x7/uDX39sXt/67cMoDyOVgMjBjYFbV/8kkqcCBrIER5KS/967s+rmkXxzI5wJiRSBm/v8P7NTfHHFFl5mVdIzhGv4+u///x+xmuAlcdXPB9KeqeLgYd3bDU2ZpRRmwH4DOeAI07QXIRKipYPD35184/nn17CO4p/+cOfjl76+/X4GYAYThGn7/g+Mfh/ZZwjUA/aABpJVhpv6+dQUjZP78Z0YEK7OezS2gwltg64GmfTu6i+HL+mUMP34wgvGvL78ZOEysf8M1sGgZvQIqfA1SDAL8iUUMPIFRQLf+AmMQ4DQ0vYYSrL9vXDz2sq9LFsiX4dLRA0t8OX0SHKzi5bXf2HUMBVA0gN356N7p7xdOS3w5fAgcfNxWtn+BJi9gVVBOQfYPQIABABvRq3BwGT3OAAAAAElFTkSuQmCC");
        background-position:5px center;
        background-repeat:no-repeat;
    }
    input:required:valid,
    textarea:required:valid
    {
        padding-left:20px;
        background-image:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAYAAABWdVznAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAZZJREFUeNpi/P//PwMpgImBRMAy58QshrNPTzP8+vOLIUInisFQyYjhz98/DB9/fmT48/+35v7H+8KNhE2+WclZd+G0gZmJmYGThUNz1fUVMZtvbWT59eUXG9wGZIWMUPj993eJ5VeWxuy8veM/CzPL3yfvH/9H0QBSBDYZyOVm4mGYfn6q4cory5lYmFh+MrEwM/76/YsR7mk2ZjbWP///WP37/y8cqIDhx58fjvtu7XV6//ndT34G/v8FasUsDjKO/+A2PP3wpGLd+TVsfOz8XH6KAT+nHpokcu7h6d9q/BoMxToVbBYqlt9///+1GO4/WVdpXqY/zMqXn13/+vTjI9mj94/y//v9/3e9ZRObvYbDT0Y2xnm///x+wsfHB3GSGLf41jb3rv0O8nbcR66d+HPvxf2/+YZFTHaqjl8YWBnm/vv37yly5LL8+vuLgYuVa3uf/4T/Kd8SnSTZpb6FGUXwcvJxbAPKP2VkZESNOBDx8+9PBm4OwR1TwmYwcfzjsBUQFLjOxs52A2YyKysrXANAgAEA7buhysQuIREAAAAASUVORK5CYII=");
        background-position:5px center;
        background-repeat:no-repeat;
    }
    input[type="range"]
    {
        padding:3px;
        cursor:pointer;
    }
    input[type="range"][orient="vertical"]
    {
        writing-mode:bt-lr;
        -webkit-appearance:slider-vertical;
    }
    .LABEL_TEXT
    {

    }

/*---------------------------------------------------------------------------*/
/* PAGE NAVIGATION
/*---------------------------------------------------------------------------*/

    .PAGE_NAVIGATION
    {
        position:fixed;
        top:0;
        left:0;
        width:160px;
        height:100%;
        background:#323E48;
    }
    .MENU_LIST
    {
        margin:0;
        margin-top:20px;
        padding:0;
    }
    .MENU_ITEM
    {
        position:relative;
        display:block;
        list-style:none;
        margin:0;
        padding:0;
    }
    .MENU_ITEM_LINK
    {
        border-left-width:3px;
        border-left-style:solid;
        border-left-color:#323E48;
        text-align:left;
    }
    .MENU_ITEM_WITH_ASIDE
    {
        margin-right:32px;
    }
    .MENU_ITEM_LINK,
    .MENU_ITEM_ASIDE
    {
        display:block;
        height:40px;
        line-height:40px;
        padding:0 10px;
        color:#FAFAFA;
        text-decoration:none;
        text-transform:uppercase;
        font-size:100%;
        cursor:pointer;
    }
    .MENU_ITEM:hover .MENU_ITEM_LINK,
    .MENU_ITEM_ACTIVE
    {
        background:#273038;
        border-left-color:green;
    }
    .MENU_ITEM:hover .MENU_ITEM_LINK
    {
        text-decoration:underline;
    }
    .MENU_ITEM_ASIDE
    {
        position:absolute;
        top:0;
        right:0;
        width:10px;
        text-align:center;
    }
    .MENU_ITEM_ASIDE:hover
    {
        background:#273038;
    }

/*---------------------------------------------------------------------------*/
/* PAGE
/*---------------------------------------------------------------------------*/

    .PAGE_MAIN
    {
        position:relative;
        vertical-align:top;
        display:inline-block;
        margin-top:20px;
        margin-right:20px;
        margin-left:20px;
        background:white;
        border:0;
        border-radius:5mm;
    }
    .PAGE_HEADER
    {
        position:relative;
        display:block;
        z-index:1;
    }
    .PAGE_HEADLINE
    {
        padding:10px 40px;
        background:#aaa;
        font-size:150%;
    }
    .PAGE_SECTION
    {
        position:relative;
        display:block;
        z-index:2;
    }
    .PAGE_FOOTER
    {
        position:relative;
        display:block;
        z-index:3;
    }

/*---------------------------------------------------------------------------*/
/* FORM CONTAINER
/*---------------------------------------------------------------------------*/

    .FORM_CONTAINER
    {
        vertical-align:top;
        display:inline-block;
        width:500px;
        margin-top:20px;
        margin-left:20px;
        padding:20px;
        background:white;
        border-radius:5mm;
        border:1px solid black;
    }
    .FORM_CONTAINER .INPUT_HEADER
    {
        display:block;
        line-height:100%;
        margin:0;
        padding:7.5px 10px;
        border:none;
        border-left:15px solid #aaa;
        border-bottom:1px solid #aaa;
        border-right:1px solid #aaa;
        background:#aaa;
    }
    .FORM_CONTAINER .INPUT_TEXT,
    .FORM_CONTAINER .INPUT_RANGE,
    .FORM_CONTAINER .INPUT_COLOR
    {
        height:36px;
        padding:10px;
        background:white;
        border-left:15px solid #aaa;
        border-bottom:1px solid #aaa;
        border-right:1px solid #aaa;
    }
    .FORM_CONTAINER .LABEL_TEXT
    {
        display:block;
        padding:10px;
        line-height:36px;
        border-left:15px solid #aaa;
        border-bottom:1px solid #aaa;
        border-right:1px solid #aaa;
    }
    .FORM_CONTAINER .INPUT_TEXT
    {
        padding-right:65px;
    }
    .FORM_CONTAINER .INPUT_RADIO_LABEL,
    .FORM_CONTAINER .INPUT_CHECKBOX_LABEL
    {
        cursor:pointer;
        vertical-align:top;
        display:inline-block;
        width:400px;
        height:35px;
        line-height:35px;
        padding-left:10px;
        border-left:15px solid #aaa;
        border-bottom:1px solid #aaa;
        border-right:1px solid #aaa;
    }
    .FORM_CONTAINER .INPUT_RADIO_ASIDE,
    .FORM_CONTAINER .INPUT_CHECKBOX_ASIDE
    {
        cursor:pointer;
        vertical-align:middle;
        display:inline-block;
        width:73px;
        height:35px;
        line-height:35px;
        border-bottom:1px solid #aaa;
        border-right:1px solid #aaa;
        text-align:center;
    }
    .FORM_CONTAINER .INPUT_RADIO,
    .FORM_CONTAINER .INPUT_CHECKBOX
    {

    }
    .FORM_CONTAINER .INPUT_RANGE
    {
        vertical-align:middle;
        display:inline-block;
        width:390px;
        height:35px;
        line-height:35px;
        padding:0 10px;
        -webkit-appearance:none;
        -webkit-border-radius:0;
    }

    .FORM_CONTAINER .INPUT_RANGE_VALUE
    {
        vertical-align:middle;
        display:inline-block;
        width:73px;
        line-height:35px;
        border:none;
        border-bottom:1px solid #aaa;
        border-right:1px solid #aaa;
        text-align:center;
        font-size:100%;
    }
    .FORM_CONTAINER .INPUT_COLOR
    {
    }
    .FORM_CONTAINER .INPUT_SELECT
    {
        cursor:pointer;
        display:block;
        width:100%;
        height:35px;
        line-height:35px;
        padding-left:5px;
        border:none;
        border-left:15px solid #aaa;
        border-bottom:1px solid #aaa;
        font-size:100%;
        -webkit-appearance:none;
        -webkit-border-radius:0;
    }
    .FORM_CONTAINER .INPUT_SELECT optgroup
    {
        background:#aaa;
        border-left:13px solid #aaa;
        font-weight:normal;
        font-style:normal;
    }
    .FORM_CONTAINER .INPUT_SELECT option
    {
        padding:8px 0 8px 10px;
        border-left:13px solid #aaa;
    }
    .FORM_CONTAINER .INPUT_SELECT optgroup option
    {
        background:white;
        border-left:none;
    }

/*---------------------------------------------------------------------------*/
/* IMAGE EDITOR
/*---------------------------------------------------------------------------*/

    .IMAGE_BARCODE_DISPLAY_AREA
    {
        position:relative;
        padding:20px;
        background-image:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAMAAAC67D+PAAAABlBMVEUAAADi4uItTa87AAAAAXRSTlMAQObYZgAAABxJREFUeNqVyzENAAAAgzDm3/SCBHrxwIRSqr8HCywAMzdMIgoAAAAASUVORK5CYII=");
        background-repeat:repeat;
        border-radius:5mm;
        border:1px solid black;
    }

    .BARCODE_IMAGE
    {

    }

    .hidden
    {
        display:none;
    }

</style>
<nav class="PAGE_NAVIGATION">
<ul class="MENU_LIST">
<li class="MENU_ITEM"><a class="MENU_ITEM_LINK" name="test">TEMPLATES</a></li>
</ul>
</nav>
<div class="PAGE_HEADLINE">BarCode Coder Library -> Barcode Design Studio</div>

<form class="FORM_CONTAINER">
<label class="INPUT_HEADER">LINEARE CODES</label>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_BARCODE_TYPE_1">STANDARD 2 OF 5 (STD25)</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE_1" value="1"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_BARCODE_TYPE_2">INTERLEAVED 2 OF 5 (INT25)</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE_2" value="2"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_BARCODE_TYPE_3">EUROPEAN ARTICLE NUMBER 8 (EAN 8)</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE_3" value="3"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_BARCODE_TYPE_4">EUROPEAN ARTICLE NUMBER 13 (EAN 13)</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE_4" value="4"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_BARCODE_TYPE_5">UNIVERSAL PRODUCT CODE (UPC)</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE_5" value="5"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_BARCODE_TYPE_6">CODE 11</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE_6" value="6"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_BARCODE_TYPE_7">CODE 39</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE_7" value="7"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_BARCODE_TYPE_8">CODE 93</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE_8" value="8"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_BARCODE_TYPE_9">CODE 128</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE_9" value="9"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_BARCODE_TYPE_10">CODABAR</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE_10" value="10"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_BARCODE_TYPE_11">MODIFIED PLESSEY (MSI)</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE_11" value="11"></aside></div>
<label class="INPUT_HEADER">2D BARCODES</label>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_BARCODE_TYPE_12">DATA MATRIX</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE_12" value="12"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_BARCODE_TYPE_13">QUICK RESPONSE CODE (QR CODE)</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE_13" value="13" checked></aside></div>
</form>

<form class="FORM_CONTAINER">
<label class="INPUT_HEADER">BARCODE CONTENT</label>
<textarea class="INPUT_ELEMENT INPUT_TEXT TEXTAREA_RESIZE" name="INPUT_BARCODE_CONTENT" placeholder="BARCODE CONTENT ..." title="SEVERAL BARCODES: SEPARATED BY A NEW LINE OR A COMMA." autocomplete="off" pattern="[\s\d\w]+" required></textarea>
</form>

<form class="FORM_CONTAINER hidden">
<label class="INPUT_HEADER">QUICK RESPONSE CODE CENTER LOGO</label>
<input type="text" class="INPUT_ELEMENT INPUT_TEXT" name="INPUT_BARCODE_QRC_CENTER_LOGO" placeholder="QUICK RESPONSE CODE CENTER LOGO ..." autocomplete="off" pattern="[\s\d\w]+" required>
<label class="INPUT_HEADER">QUICK RESPONSE CODE TEMPLATE MODULES</label>
<input type="text" class="INPUT_ELEMENT INPUT_TEXT" name="INPUT_BARCODE_QRC_TEMPLATE_MODULES" placeholder="QUICK RESPONSE CODE TEMPLATE MODULES ..." autocomplete="off" pattern="[\s\d\w]+" required>
<label class="INPUT_HEADER">QUICK RESPONSE CODE TEMPLATE EYES</label>
<input type="text" class="INPUT_ELEMENT INPUT_TEXT" name="INPUT_BARCODE_QRC_TEMPLATE_EYES" placeholder="QUICK RESPONSE CODE TEMPLATE EYES ..." autocomplete="off" pattern="[\s\d\w]+" required>
<label class="INPUT_HEADER">QUICK RESPONSE CODE EXTERNAL EYE COLORS</label>
<input type="color" class="INPUT_ELEMENT INPUT_TEXT INPUT_COLOR" name="INPUT_BARCODE_QRC_EXTERNAL_EYE_COLORS" placeholder="QUICK RESPONSE CODE EXTERNAL EYE COLORS ..." autocomplete="off" pattern="[\s\d\w]+" required>
<label class="INPUT_HEADER">QUICK RESPONSE CODE INTERNAL EYE COLORS</label>
<input type="color" class="INPUT_ELEMENT INPUT_TEXT INPUT_COLOR" name="INPUT_BARCODE_QRC_INTERNAL_EYE_COLORS" placeholder="QUICK RESPONSE CODE INTERNAL EYE COLORS ..." autocomplete="off" pattern="[\s\d\w]+" required>
<label class="INPUT_HEADER">QUICK RESPONSE CODE SHADOW</label>
<input type="text" class="INPUT_ELEMENT INPUT_TEXT" name="INPUT_BARCODE_QRC_SHADOW" placeholder="QUICK RESPONSE CODE SHADOW ..." autocomplete="off" pattern="[\s\d\w]+" required>
<label class="INPUT_HEADER">QUICK RESPONSE CODE REDUNDANCY</label>
<input type="text" class="INPUT_ELEMENT INPUT_TEXT" name="INPUT_BARCODE_QRC_REDUNDANCY" placeholder="QUICK RESPONSE CODE REDUNDANCY ..." autocomplete="off" pattern="[\s\d\w]+" required>
</form>

<form class="FORM_CONTAINER hidden">
<label class="INPUT_HEADER">BARCODE MODULE COLOR</label>
<input type="color" class="INPUT_ELEMENT INPUT_TEXT INPUT_COLOR" name="INPUT_BARCODE_CONTENT" value="#000000">
<label class="INPUT_HEADER">BARCODE SHADED COLORS</label>
<input type="text" class="INPUT_ELEMENT INPUT_TEXT" name="INPUT_BARCODE_CONTENT" placeholder="BARCODE SHADED COLORS ..." autocomplete="off" pattern="[\s\d\w]+" required>
<label class="INPUT_HEADER">BARCODE BACKGROUND COLOR</label>
<input type="color" class="INPUT_ELEMENT INPUT_TEXT INPUT_COLOR" name="INPUT_BARCODE_CONTENT" value="#FFFFFF">
<label class="INPUT_HEADER">BARCODE BACKGROUND IMAGE</label>
<input type="file" class="INPUT_ELEMENT INPUT_TEXT" name="INPUT_BARCODE_CONTENT" placeholder="BARCODE BACKGROUND IMAGE ..." autocomplete="off" pattern="[\s\d\w]+" required>
</form>

<form class="FORM_CONTAINER">
<label class="INPUT_HEADER">BARCODE MARGIN TOP (UNIT IN PIXELS)</label>
<div class="FORM_CONTAINER_INPUT"><input type="range" class="INPUT_ELEMENT INPUT_RANGE" name="INPUT_BARCODE_MARGIN_TOP" autocomplete="off" min="0" max="1000" step="1" value="0"><input type="text" class="INPUT_ELEMENT INPUT_RANGE_VALUE" name="INPUT_BARCODE_MARGIN_TOP" autocomplete="off" maxlength="5"></div>
<label class="INPUT_HEADER">BARCODE MARGIN RIGHT (UNIT IN PIXELS)</label>
<div class="FORM_CONTAINER_INPUT"><input type="range" class="INPUT_ELEMENT INPUT_RANGE" name="INPUT_BARCODE_MARGIN_RIGHT" autocomplete="off" min="0" max="1000" step="1" value="0"><input type="text" class="INPUT_ELEMENT INPUT_RANGE_VALUE" name="INPUT_BARCODE_MARGIN_RIGHT" autocomplete="off" maxlength="5"></div>
<label class="INPUT_HEADER">BARCODE MARGIN BOTTOM (UNIT IN PIXELS)</label>
<div class="FORM_CONTAINER_INPUT"><input type="range" class="INPUT_ELEMENT INPUT_RANGE" name="INPUT_BARCODE_MARGIN_BOTTOM" autocomplete="off" min="0" max="1000" step="1" value="0"><input type="text" class="INPUT_ELEMENT INPUT_RANGE_VALUE" name="INPUT_BARCODE_MARGIN_BOTTOM" autocomplete="off" maxlength="5"></div>
<label class="INPUT_HEADER">BARCODE MARGIN LEFT (UNIT IN PIXELS)</label>
<div class="FORM_CONTAINER_INPUT"><input type="range" class="INPUT_ELEMENT INPUT_RANGE" name="INPUT_BARCODE_MARGIN_LEFT" autocomplete="off" min="0" max="1000" step="1" value="0"><input type="text" class="INPUT_ELEMENT INPUT_RANGE_VALUE" name="INPUT_BARCODE_MARGIN_LEFT" autocomplete="off" maxlength="5"></div>
</form>

<form class="FORM_CONTAINER">
<label class="INPUT_HEADER">IMAGE RESIZE WIDTH (UNIT IS THE SELECTED SCALE)</label>
<div class="FORM_CONTAINER_INPUT"><input type="range" class="INPUT_ELEMENT INPUT_RANGE" name="INPUT_IMAGE_RESIZE_WIDTH" autocomplete="off" min="1" max="1000" step="1" value="100"><input type="text" class="INPUT_ELEMENT INPUT_RANGE_VALUE" name="INPUT_IMAGE_RESIZE_WIDTH" autocomplete="off" maxlength="5"></div>
<label class="INPUT_HEADER">IMAGE RESIZE HEIGHT (UNIT IS THE SELECTED SCALE)</label>
<div class="FORM_CONTAINER_INPUT"><input type="range" class="INPUT_ELEMENT INPUT_RANGE" name="INPUT_IMAGE_RESIZE_HEIGHT" autocomplete="off" min="1" max="1000" step="1" value="100"><input type="text" class="INPUT_ELEMENT INPUT_RANGE_VALUE" name="INPUT_IMAGE_RESIZE_HEIGHT" autocomplete="off" maxlength="5"></div>
<label class="INPUT_HEADER">IMAGE RESIZE SCALE</label>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_IMAGE_RESIZE_SCALE_1">INCHES (IN)</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_IMAGE_RESIZE_SCALE" id="INPUT_IMAGE_RESIZE_SCALE_1" value="1"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_IMAGE_RESIZE_SCALE_2">CENTIMETER (CM)</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_IMAGE_RESIZE_SCALE" id="INPUT_IMAGE_RESIZE_SCALE_2" value="2"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_IMAGE_RESIZE_SCALE_3">MILLIMETER (MM)</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_IMAGE_RESIZE_SCALE" id="INPUT_IMAGE_RESIZE_SCALE_3" value="3" checked></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_IMAGE_RESIZE_SCALE_4">PIXELS (PX)</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_IMAGE_RESIZE_SCALE" id="INPUT_IMAGE_RESIZE_SCALE_4" value="4"></aside></div>
<label class="INPUT_HEADER">IMAGE RESIZE DOTS PER INCH (DPI)</label>
<div class="FORM_CONTAINER_INPUT"><input type="range" class="INPUT_ELEMENT INPUT_RANGE" name="INPUT_IMAGE_RESIZE_DPI" autocomplete="off" min="60" max="600" step="30" value="600"><input type="text" class="INPUT_ELEMENT INPUT_RANGE_VALUE" name="INPUT_IMAGE_RESIZE_DPI" autocomplete="off" maxlength="5"></div>
</form>

<form class="FORM_CONTAINER">
<label class="INPUT_HEADER">IMAGE ORIENTATON</label>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_IMAGE_ORIENTATON_1">TOP</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_IMAGE_ORIENTATON" id="INPUT_IMAGE_ORIENTATON_1" value="1" checked></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_IMAGE_ORIENTATON_2">RIGHT</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_IMAGE_ORIENTATON" id="INPUT_IMAGE_ORIENTATON_2" value="2"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_IMAGE_ORIENTATON_3">BOTTOM</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_IMAGE_ORIENTATON" id="INPUT_IMAGE_ORIENTATON_3" value="3"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_IMAGE_ORIENTATON_4">LEFT</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_IMAGE_ORIENTATON" id="INPUT_IMAGE_ORIENTATON_4" value="4"></aside></div>
<label class="INPUT_HEADER">IMAGE QUALITY (UNIT IN PERCENT AND ONLY VALID WITH JPEG)</label>
<div class="FORM_CONTAINER_INPUT"><input type="range" class="INPUT_ELEMENT INPUT_RANGE" name="INPUT_IMAGE_QUALITY" autocomplete="off" min="10" max="100" step="10" value="80"><input type="text" class="INPUT_ELEMENT INPUT_RANGE_VALUE" name="INPUT_IMAGE_QUALITY" autocomplete="off" min="10" max="100" maxlength="5"></div>
<label class="INPUT_HEADER">IMAGE FORMAT</label>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_IMAGE_FORMAT_1">GRAPHICS INTERCHANGE FORMAT (GIF)</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_IMAGE_FORMAT" id="INPUT_IMAGE_FORMAT_1" value="1"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_IMAGE_FORMAT_2">PORTABLE NETWORK GRAPHICS (PNG)</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_IMAGE_FORMAT" id="INPUT_IMAGE_FORMAT_2" value="2" checked></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_IMAGE_FORMAT_3">JOINT PHOTOGRAPHIC EXPERTS GROUP (JPEG)</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_IMAGE_FORMAT" id="INPUT_IMAGE_FORMAT_3" value="3"></aside></div>
<label class="INPUT_HEADER">IMAGE OUTPUT</label>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_IMAGE_OUTPUT_1">DISPLAY THE IMAGE</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_IMAGE_OUTPUT" id="INPUT_IMAGE_OUTPUT_1" value="1" checked></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_IMAGE_OUTPUT_2">START A FILE DOWNLOAD</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_IMAGE_OUTPUT" id="INPUT_IMAGE_OUTPUT_2" value="2"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_IMAGE_OUTPUT_3">SAVE THE IMAGE TO A FILE</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_IMAGE_OUTPUT" id="INPUT_IMAGE_OUTPUT_3" value="3"></aside></div>

<label class="INPUT_HEADER">FILE NAME FORMAT (WRITE PERMISSIONS ARE REQUIRED)</label>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_FILE_NAME_FORMAT_1">BARCODE-TYPE-CONTENT.EXTENSION</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_FILE_NAME_FORMAT" id="INPUT_FILE_NAME_FORMAT_1" value="1" checked></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_FILE_NAME_FORMAT_2">BARCODE-TYPE-SHA1(CONTENT).EXTENSION</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_FILE_NAME_FORMAT" id="INPUT_FILE_NAME_FORMAT_2" value="2"></aside></div>
<input type="text" class="INPUT_ELEMENT INPUT_TEXT" name="INPUT_FILE_NAME_FORMAT" placeholder="FILE NAME ..." autocomplete="off">

</form>

<form class="FORM_CONTAINER">
<label class="INPUT_HEADER">URL OF THE BARCODE CONFIGURATION </label>
<label class="LABEL_TEXT" name="BARCODE_CONFIGURATION"></label>
</form>

<form class="FORM_CONTAINER hidden">
<label class="INPUT_HEADER">RADIO</label>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_RADIO_TEST_1">TEST 1</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_RADIO_TEST" id="INPUT_RADIO_TEST_1" value="1"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_RADIO_TEST_2">TEST 2</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_RADIO_TEST" id="INPUT_RADIO_TEST_2" value="2" checked></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_RADIO_LABEL" for="INPUT_RADIO_TEST_3">TEST 3</label><aside class="INPUT_RADIO_ASIDE"><input type="radio" class="INPUT_ELEMENT INPUT_RADIO" name="INPUT_RADIO_TEST" id="INPUT_RADIO_TEST_3" value="3"></aside></div>
</form>

<form class="FORM_CONTAINER hidden">
<label class="INPUT_HEADER">CHECKBOX</label>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_CHECKBOX_LABEL" for="INPUT_CHECKBOX_TEST_1">TEST 1</label><aside class="INPUT_CHECKBOX_ASIDE"><input type="checkbox" class="INPUT_ELEMENT INPUT_CHECKBOX" name="INPUT_CHECKBOX_TEST_1" id="INPUT_CHECKBOX_TEST_1" value="1"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_CHECKBOX_LABEL" for="INPUT_CHECKBOX_TEST_2">TEST 2</label><aside class="INPUT_CHECKBOX_ASIDE"><input type="checkbox" class="INPUT_ELEMENT INPUT_CHECKBOX" name="INPUT_CHECKBOX_TEST_2" id="INPUT_CHECKBOX_TEST_2" value="2" checked></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="INPUT_CHECKBOX_LABEL" for="INPUT_CHECKBOX_TEST_3">TEST 3</label><aside class="INPUT_CHECKBOX_ASIDE"><input type="checkbox" class="INPUT_ELEMENT INPUT_CHECKBOX" name="INPUT_CHECKBOX_TEST_3" id="INPUT_CHECKBOX_TEST_3" value="3"></aside></div>
</form>

<form class="FORM_CONTAINER hidden">
<label class="INPUT_HEADER" for="INPUT_SELECT_TEST_1">SELECT</label>
<select class="INPUT_SELECT" id="INPUT_SELECT_TEST_1" name="INPUT_SELECT_TEST_1">
<option value="111">111</option>
<option value="222">222</option>
<optgroup label="AAA">
<option value="111">111</option>
<option value="222" selected>222</option>
</optgroup>
<optgroup label="BBB">
<option value="333">333</option>
<option value="444">444</option>
</optgroup>
</select>
</form>

<main class="PAGE_MAIN">
<div class="IMAGE_BARCODE_DISPLAY_AREA">
<img class="BARCODE_IMAGE" alt="BARCODE">
</div>
</main>

<script type="text/javascript">

    function ajax_request_handling() { var request = null; try { request = new XMLHttpRequest(); } catch ( error ) { try { request = new ActiveXObject( 'Msxml2.XMLHTTP' ); } catch ( error ) { try { request = new ActiveXObject( 'Microsoft.XMLHTTP' ); } catch ( error ) { return false; } } } return request; }

    //-------------------------------------------------
    // BARCODE CONFIGURATION AND URL
    //-------------------------------------------------

    var BARCODE_CONFIGURATION = new Object();

    function GENERATE_BARCODE_URL()
    {
        var BARCODE_URL = '';

        for ( INDEX in BARCODE_CONFIGURATION )
        {
            BARCODE_URL += '&' + INDEX + '=' + BARCODE_CONFIGURATION[ INDEX ];
        }

        document.getElementsByClassName( 'BARCODE_IMAGE' )[ 0 ].src = './php-barcode.test.php?a=1' + BARCODE_URL;

        document.getElementsByName( 'BARCODE_CONFIGURATION' )[ 0 ].innerHTML = BARCODE_URL;
    }

    //-------------------------------------------------
    // INPUT RANGE
    //-------------------------------------------------

    function INPUT_RANGE()
    {
        var a = document.getElementsByClassName( 'INPUT_RANGE' );

        for ( var b = 0; b < a.length; b++ )
        {
            document.getElementsByName( a[ b ].name )[ 1 ].value = a[ b ].value;

            a[ b ].oninput = function( event )
            {
                document.getElementsByName( this.name )[ 1 ].value = this.value;
            }
        }

        var a = document.getElementsByClassName( 'INPUT_RANGE_VALUE' );

        for ( var b = 0; b < a.length; b++ )
        {
            a[ b ].onkeyup = function( event )
            {
                document.getElementsByName( this.name )[ 0 ].value = this.value;
            }
        }
    }

    INPUT_RANGE();

    //-------------------------------------------------
    // INPUT ELEMENT
    //-------------------------------------------------

    var a = document.getElementsByClassName( 'INPUT_ELEMENT' );

    for ( var b = 0; b < a.length; b++ )
    {
        if ( a[ b ].type == 'text' || a[ b ].type == 'radio' && a[ b ].checked == true )
        {
            BARCODE_CONFIGURATION[ a[ b ].name ] = encodeURIComponent( a[ b ].value );
        }

        a[ b ].onchange = function(event)
        {
            BARCODE_CONFIGURATION[ this.name ] = encodeURIComponent( this.value );

            if ( this.name == 'INPUT_BARCODE_TYPE' )
            {
                switch ( this.value )
                {
                    case '1':
                    {
                        SET_BARCODE_PROPERTY( 'INPUT_BARCODE_CONTENT', '111222333' );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_WIDTH', 373 );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_HEIGHT', 259 );
                    }
                    break;
                    case '2':
                    {
                        SET_BARCODE_PROPERTY( 'INPUT_BARCODE_CONTENT', '111222333' );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_WIDTH', 373 );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_HEIGHT', 259 );
                    }
                    break;
                    case '3':
                    {
                        SET_BARCODE_PROPERTY( 'INPUT_BARCODE_CONTENT', '11223344' );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_WIDTH', 373 );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_HEIGHT', 259 );
                    }
                    break;
                    case '4':
                    {
                        SET_BARCODE_PROPERTY( 'INPUT_BARCODE_CONTENT', '1234567890123' );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_WIDTH', 373 );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_HEIGHT', 259 );
                    }
                    break;
                    case '5':
                    {
                        SET_BARCODE_PROPERTY( 'INPUT_BARCODE_CONTENT', '123456789012' );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_WIDTH', 373 );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_HEIGHT', 259 );
                    }
                    break;
                    case '6':
                    {
                        SET_BARCODE_PROPERTY( 'INPUT_BARCODE_CONTENT', '111222333' );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_WIDTH', 373 );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_HEIGHT', 259 );
                    }
                    break;
                    case '7':
                    {
                        SET_BARCODE_PROPERTY( 'INPUT_BARCODE_CONTENT', '111222333' );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_WIDTH', 373 );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_HEIGHT', 259 );
                    }
                    break;
                    case '8':
                    {
                        SET_BARCODE_PROPERTY( 'INPUT_BARCODE_CONTENT', '111222333' );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_WIDTH', 373 );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_HEIGHT', 259 );
                    }
                    break;
                    case '9':
                    {
                        SET_BARCODE_PROPERTY( 'INPUT_BARCODE_CONTENT', 'TEST12345' );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_WIDTH', 373 );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_HEIGHT', 259 );
                    }
                    break;
                    case '10':
                    {
                        SET_BARCODE_PROPERTY( 'INPUT_BARCODE_CONTENT', '0123456789-$:/.' );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_WIDTH', 373 );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_HEIGHT', 259 );
                    }
                    break;
                    case '11':
                    {
                        SET_BARCODE_PROPERTY( 'INPUT_BARCODE_CONTENT', '111222333' );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_WIDTH', 373 );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_HEIGHT', 259 );
                    }
                    break;
                    case '12':
                    {
                        SET_BARCODE_PROPERTY( 'INPUT_BARCODE_CONTENT', 'TEST12345' );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_WIDTH', 100 );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_HEIGHT', 100 );
                    }
                    break;
                    case '13':
                    {
                        SET_BARCODE_PROPERTY( 'INPUT_BARCODE_CONTENT', 'TEST12345' );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_WIDTH', 100 );
                        SET_BARCODE_PROPERTY( 'INPUT_IMAGE_RESIZE_HEIGHT', 100 );
                    }
                    break;
                }
            }

            GENERATE_BARCODE_URL();
        }
    }

    GENERATE_BARCODE_URL();

    //-------------------------------------------------
    // SET BARCODE PROPERTY
    //-------------------------------------------------

    function SET_BARCODE_PROPERTY( BARCODE_KEY, BARCODE_VALUE )
    {
        if ( typeof document.getElementsByName( BARCODE_KEY )[ 0 ] != 'undefined' )
        {
            document.getElementsByName( BARCODE_KEY )[ 0 ].value = BARCODE_VALUE;
        }

        if ( typeof document.getElementsByName( BARCODE_KEY )[ 1 ] != 'undefined' )
        {
            document.getElementsByName( BARCODE_KEY )[ 1 ].value = BARCODE_VALUE;
        }

        BARCODE_CONFIGURATION[ BARCODE_KEY ] = encodeURIComponent( BARCODE_VALUE );
    }

    //-------------------------------------------------
    // TEXTAREA RESIZE
    //-------------------------------------------------

    function TEXTAREA_RESIZE()
    {
        var a = document.getElementsByClassName( 'TEXTAREA_RESIZE' );

        for ( var b = 0; b < a.length; b++ )
        {
            a[ b ].style.height = a[ b ].scrollHeight + 'px';

            a[ b ].onkeyup = function( event )
            {
                this.style.height = this.scrollHeight + 'px';
            }
        }
    }
    
    setTimeout( TEXTAREA_RESIZE, 500 );

</script>