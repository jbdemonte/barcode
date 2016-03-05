<!DOCTYPE html>
<html lang="de">
<title>BarCode Coder Library -> Barcode Design Studio</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
<link href="./favicon.ico" rel="shortcut icon">
<style type="text/css" media="all">

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
    input[type="range"]
    {
        padding:3px;
        cursor:pointer;
    }
    input[type="range"][orient="vertical"]
    {
        writing-mode: bt-lr;
        -webkit-appearance: slider-vertical;
    }

/*---------------------------------------------------------------------------*/
/* INPUT-TEXT / INPUT-BUTTON / LABEL-TEXT
/*---------------------------------------------------------------------------*/

    .input-text
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
        /* white-space:normal; */
        /* letter-spacing:1px; */
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
    .input-button
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
        letter-spacing:1px;
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
    .input-button:hover
    {
        text-decoration:none;
    }
    input:required:invalid,
    input:focus:invalid,
    textarea:required:invalid,
    textarea:focus:invalid 
    {
        background-image:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAYAAABWdVznAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAT1JREFUeNpi/P//PwMpgImBRMACY/x7/uDX39sXt/67cMoDyOVgMjBjYFbV/8kkqcCBrIER5KS/967s+rmkXxzI5wJiRSBm/v8P7NTfHHFFl5mVdIzhGv4+u///x+xmuAlcdXPB9KeqeLgYd3bDU2ZpRRmwH4DOeAI07QXIRKipYPD35184/nn17CO4p/+cOfjl76+/X4GYAYThGn7/g+Mfh/ZZwjUA/aABpJVhpv6+dQUjZP78Z0YEK7OezS2gwltg64GmfTu6i+HL+mUMP34wgvGvL78ZOEysf8M1sGgZvQIqfA1SDAL8iUUMPIFRQLf+AmMQ4DQ0vYYSrL9vXDz2sq9LFsiX4dLRA0t8OX0SHKzi5bXf2HUMBVA0gN356N7p7xdOS3w5fAgcfNxWtn+BJi9gVVBOQfYPQIABABvRq3BwGT3OAAAAAElFTkSuQmCC");
        background-position:95% center;
        background-repeat:no-repeat;
    }
    input:required:valid,
    textarea:required:valid 
    {
        background-image:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAwAAAAMCAYAAABWdVznAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAZZJREFUeNpi/P//PwMpgImBRMAy58QshrNPTzP8+vOLIUInisFQyYjhz98/DB9/fmT48/+35v7H+8KNhE2+WclZd+G0gZmJmYGThUNz1fUVMZtvbWT59eUXG9wGZIWMUPj993eJ5VeWxuy8veM/CzPL3yfvH/9H0QBSBDYZyOVm4mGYfn6q4cory5lYmFh+MrEwM/76/YsR7mk2ZjbWP///WP37/y8cqIDhx58fjvtu7XV6//ndT34G/v8FasUsDjKO/+A2PP3wpGLd+TVsfOz8XH6KAT+nHpokcu7h6d9q/BoMxToVbBYqlt9///+1GO4/WVdpXqY/zMqXn13/+vTjI9mj94/y//v9/3e9ZRObvYbDT0Y2xnm///x+wsfHB3GSGLf41jb3rv0O8nbcR66d+HPvxf2/+YZFTHaqjl8YWBnm/vv37yly5LL8+vuLgYuVa3uf/4T/Kd8SnSTZpb6FGUXwcvJxbAPKP2VkZESNOBDx8+9PBm4OwR1TwmYwcfzjsBUQFLjOxs52A2YyKysrXANAgAEA7buhysQuIREAAAAASUVORK5CYII=");
        background-position:95% center;
        background-repeat:no-repeat;
    }
    .label-text
    {

    }

/*---------------------------------------------------------------------------*/
/* PAGE NAVIGATION
/*---------------------------------------------------------------------------*/

    .page-navigation
    {
        position:fixed;
        top:0;
        left:0;
        width:160px;
        height:100%;
        background:#323E48;
    }
    .menu-list
    {
        margin:0;
        margin-top:60px;
        padding:0;
    }
    .menu-item
    {
        position:relative;
        display:block;
        list-style:none;
        margin:0;
        padding:0;
    }
    .menu-item-link
    {
        border-left-width:3px;
        border-left-style:solid;
        border-left-color:#323E48;
        text-align:left;
    }
    .menu-item-with-aside
    {
        margin-right:32px;
    }
    .menu-item-link,
    .menu-item-aside
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
    .menu-item:hover .menu-item-link,
    .menu-item-active
    {
        background:#273038;
        border-left-color:green;
    }
    .menu-item:hover .menu-item-link
    {
        text-decoration:underline;
    }
    .menu-item-aside
    {
        position:absolute;
        top:0;
        right:0;
        width:10px;
        text-align:center;
    }
    .menu-item-aside:hover
    {
        background:#273038;
    }

/*---------------------------------------------------------------------------*/
/* PAGE MAIN
/*---------------------------------------------------------------------------*/

    .page-main
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
    .page-header
    {
        position:relative;
        display:block;
        z-index:1;
    }
    .page-headline
    {
        padding:10px 40px;
        background:#aaa;
        font-size:150%;
    }
    .page-section
    {
        position:relative;
        display:block;
        z-index:2;
    }
    .page-footer
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
    .FORM_CONTAINER .input-header
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
    .FORM_CONTAINER .input-text,
    .FORM_CONTAINER .input-range,
    .FORM_CONTAINER .input-color
    {
        height:36px;
        padding:10px;
        background:white;
        border-left:15px solid #aaa;
        border-bottom:1px solid #aaa;
        border-right:1px solid #aaa;
    }
    .FORM_CONTAINER .label-text
    {
        display:block;
        padding:10px;
        line-height:36px;
        border-left:15px solid #aaa;
        border-bottom:1px solid #aaa;
        border-right:1px solid #aaa;
    }
    .FORM_CONTAINER .input-text
    {
        padding-right:65px;
    }
    .FORM_CONTAINER .input-radio-label,
    .FORM_CONTAINER .input-checkbox-label
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
    .FORM_CONTAINER .input-radio-aside,
    .FORM_CONTAINER .input-checkbox-aside
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
    .FORM_CONTAINER .input-radio,
    .FORM_CONTAINER .input-checkbox
    {

    }
    .FORM_CONTAINER .input-range
    {
        vertical-align:middle;
        display:inline-block;
        width:390px;
        height:35px;
        line-height:35px;
        padding:0 10px;
    }

    .FORM_CONTAINER .input-range-value
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
    .FORM_CONTAINER .input-color
    {
    }

/*---------------------------------------------------------------------------*/
/* IMAGE EDITOR
/*---------------------------------------------------------------------------*/

    .BARCODE_DISPLAY_AREA
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
<nav class="page-navigation">
<ul class="menu-list">
<li class="menu-item"><a class="menu-item-link" name="test">TEMPLATES</a></li>
</ul>
</nav>
<div class="page-headline">BarCode Coder Library -> Barcode Design Studio</div>

<form class="FORM_CONTAINER">
<label class="input-header">LINEARE CODES</label>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_BARCODE_TYPE-1">STANDARD 2 OF 5 (STD25)</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE-1" value="1"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_BARCODE_TYPE-2">INTERLEAVED 2 OF 5 (INT25)</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE-2" value="2"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_BARCODE_TYPE-3">EUROPEAN ARTICLE NUMBER 8 (EAN 8)</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE-3" value="3"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_BARCODE_TYPE-4">EUROPEAN ARTICLE NUMBER 13 (EAN 13)</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE-4" value="4"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_BARCODE_TYPE-5">UNIVERSAL PRODUCT CODE (UPC)</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE-5" value="5"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_BARCODE_TYPE-6">CODE 11</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE-6" value="6"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_BARCODE_TYPE-7">CODE 39</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE-7" value="7"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_BARCODE_TYPE-8">CODE 93</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE-8" value="8"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_BARCODE_TYPE-9">CODE 128</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE-9" value="9"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_BARCODE_TYPE-10">CODABAR</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE-10" value="10"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_BARCODE_TYPE-11">MODIFIED PLESSEY (MSI)</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE-11" value="11"></aside></div>
<label class="input-header">2D BARCODES</label>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_BARCODE_TYPE-12">DATA MATRIX</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE-12" value="12"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_BARCODE_TYPE-13">QUICK RESPONSE CODE (QR CODE)</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_BARCODE_TYPE" id="INPUT_BARCODE_TYPE-13" value="13" checked></aside></div>
</form>

<form class="FORM_CONTAINER">
<label class="input-header">BARCODE CONTENT</label>
<textarea class="input-element input-text textarea-resize" name="INPUT_BARCODE_CONTENT" placeholder="BARCODE CONTENT ..." title="SEVERAL BARCODES: SEPARATED BY A NEW LINE OR A COMMA." autocomplete="off" pattern="[\s\d\w]+" required></textarea>
</form>

<form class="FORM_CONTAINER hidden">
<label class="input-header">QUICK RESPONSE CODE CENTER LOGO</label>
<input type="text" class="input-element input-text" name="INPUT_BARCODE_QRC_CENTER_LOGO" placeholder="QUICK RESPONSE CODE CENTER LOGO ..." autocomplete="off" pattern="[\s\d\w]+" required>
<label class="input-header">QUICK RESPONSE CODE TEMPLATE MODULES</label>
<input type="text" class="input-element input-text" name="INPUT_BARCODE_QRC_TEMPLATE_MODULES" placeholder="QUICK RESPONSE CODE TEMPLATE MODULES ..." autocomplete="off" pattern="[\s\d\w]+" required>
<label class="input-header">QUICK RESPONSE CODE TEMPLATE EYES</label>
<input type="text" class="input-element input-text" name="INPUT_BARCODE_QRC_TEMPLATE_EYES" placeholder="QUICK RESPONSE CODE TEMPLATE EYES ..." autocomplete="off" pattern="[\s\d\w]+" required>
<label class="input-header">QUICK RESPONSE CODE EXTERNAL EYE COLORS</label>
<input type="color" class="input-element input-text input-color" name="INPUT_BARCODE_QRC_EXTERNAL_EYE_COLORS" placeholder="QUICK RESPONSE CODE EXTERNAL EYE COLORS ..." autocomplete="off" pattern="[\s\d\w]+" required>
<label class="input-header">QUICK RESPONSE CODE INTERNAL EYE COLORS</label>
<input type="color" class="input-element input-text input-color" name="INPUT_BARCODE_QRC_INTERNAL_EYE_COLORS" placeholder="QUICK RESPONSE CODE INTERNAL EYE COLORS ..." autocomplete="off" pattern="[\s\d\w]+" required>
<label class="input-header">QUICK RESPONSE CODE SHADOW</label>
<input type="text" class="input-element input-text" name="INPUT_BARCODE_QRC_SHADOW" placeholder="QUICK RESPONSE CODE SHADOW ..." autocomplete="off" pattern="[\s\d\w]+" required>
<label class="input-header">QUICK RESPONSE CODE REDUNDANCY</label>
<input type="text" class="input-element input-text" name="INPUT_BARCODE_QRC_REDUNDANCY" placeholder="QUICK RESPONSE CODE REDUNDANCY ..." autocomplete="off" pattern="[\s\d\w]+" required>
</form>

<form class="FORM_CONTAINER hidden">
<label class="input-header">BARCODE MODULE COLOR</label>
<input type="color" class="input-element input-text input-color" name="INPUT_BARCODE_CONTENT" value="#000000">
<label class="input-header">BARCODE SHADED COLORS</label>
<input type="text" class="input-element input-text" name="INPUT_BARCODE_CONTENT" placeholder="BARCODE SHADED COLORS ..." autocomplete="off" pattern="[\s\d\w]+" required>
<label class="input-header">BARCODE BACKGROUND COLOR</label>
<input type="color" class="input-element input-text input-color" name="INPUT_BARCODE_CONTENT" value="#FFFFFF">
<label class="input-header">BARCODE BACKGROUND IMAGE</label>
<input type="file" class="input-element input-text" name="INPUT_BARCODE_CONTENT" placeholder="BARCODE BACKGROUND IMAGE ..." autocomplete="off" pattern="[\s\d\w]+" required>
</form>

<form class="FORM_CONTAINER">
<label class="input-header">BARCODE MARGIN TOP (UNIT IN PIXELS)</label>
<div class="FORM_CONTAINER_INPUT"><input type="range" class="input-element input-range" name="INPUT_BARCODE_MARGIN_TOP" autocomplete="off" min="0" max="1000" step="1" value="0"><input type="text" class="input-element input-range-value" name="INPUT_BARCODE_MARGIN_TOP" autocomplete="off" maxlength="5"></div>
<label class="input-header">BARCODE MARGIN RIGHT (UNIT IN PIXELS)</label>
<div class="FORM_CONTAINER_INPUT"><input type="range" class="input-element input-range" name="INPUT_BARCODE_MARGIN_RIGHT" autocomplete="off" min="0" max="1000" step="1" value="0"><input type="text" class="input-element input-range-value" name="INPUT_BARCODE_MARGIN_RIGHT" autocomplete="off" maxlength="5"></div>
<label class="input-header">BARCODE MARGIN BOTTOM (UNIT IN PIXELS)</label>
<div class="FORM_CONTAINER_INPUT"><input type="range" class="input-element input-range" name="INPUT_BARCODE_MARGIN_BOTTOM" autocomplete="off" min="0" max="1000" step="1" value="0"><input type="text" class="input-element input-range-value" name="INPUT_BARCODE_MARGIN_BOTTOM" autocomplete="off" maxlength="5"></div>
<label class="input-header">BARCODE MARGIN LEFT (UNIT IN PIXELS)</label>
<div class="FORM_CONTAINER_INPUT"><input type="range" class="input-element input-range" name="INPUT_BARCODE_MARGIN_LEFT" autocomplete="off" min="0" max="1000" step="1" value="0"><input type="text" class="input-element input-range-value" name="INPUT_BARCODE_MARGIN_LEFT" autocomplete="off" maxlength="5"></div>
</form>

<form class="FORM_CONTAINER">
<label class="input-header">IMAGE RESIZE WIDTH (UNIT IS THE SELECTED SCALE)</label>
<div class="FORM_CONTAINER_INPUT"><input type="range" class="input-element input-range" name="INPUT_IMAGE_RESIZE_WIDTH" autocomplete="off" min="1" max="1000" step="1" value="100"><input type="text" class="input-element input-range-value" name="INPUT_IMAGE_RESIZE_WIDTH" autocomplete="off" maxlength="5"></div>
<label class="input-header">IMAGE RESIZE HEIGHT (UNIT IS THE SELECTED SCALE)</label>
<div class="FORM_CONTAINER_INPUT"><input type="range" class="input-element input-range" name="INPUT_IMAGE_RESIZE_HEIGHT" autocomplete="off" min="1" max="1000" step="1" value="100"><input type="text" class="input-element input-range-value" name="INPUT_IMAGE_RESIZE_HEIGHT" autocomplete="off" maxlength="5"></div>
<label class="input-header">IMAGE RESIZE SCALE</label>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_IMAGE_RESIZE_SCALE-1">INCHES (IN)</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_IMAGE_RESIZE_SCALE" id="INPUT_IMAGE_RESIZE_SCALE-1" value="1"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_IMAGE_RESIZE_SCALE-2">CENTIMETER (CM)</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_IMAGE_RESIZE_SCALE" id="INPUT_IMAGE_RESIZE_SCALE-2" value="2"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_IMAGE_RESIZE_SCALE-3">MILLIMETER (MM)</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_IMAGE_RESIZE_SCALE" id="INPUT_IMAGE_RESIZE_SCALE-3" value="3" checked></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_IMAGE_RESIZE_SCALE-4">PIXELS (PX)</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_IMAGE_RESIZE_SCALE" id="INPUT_IMAGE_RESIZE_SCALE-4" value="4"></aside></div>
<label class="input-header">IMAGE RESIZE DOTS PER INCH (DPI)</label>
<div class="FORM_CONTAINER_INPUT"><input type="range" class="input-element input-range" name="INPUT_IMAGE_RESIZE_DPI" autocomplete="off" min="60" max="600" step="30" value="300"><input type="text" class="input-element input-range-value" name="INPUT_IMAGE_RESIZE_DPI" autocomplete="off" maxlength="5"></div>
</form>

<form class="FORM_CONTAINER">
<label class="input-header">IMAGE ORIENTATON</label>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_IMAGE_ORIENTATON-1">TOP</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_IMAGE_ORIENTATON" id="INPUT_IMAGE_ORIENTATON-1" value="1" checked></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_IMAGE_ORIENTATON-2">RIGHT</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_IMAGE_ORIENTATON" id="INPUT_IMAGE_ORIENTATON-2" value="2"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_IMAGE_ORIENTATON-3">BOTTOM</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_IMAGE_ORIENTATON" id="INPUT_IMAGE_ORIENTATON-3" value="3"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_IMAGE_ORIENTATON-4">LEFT</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_IMAGE_ORIENTATON" id="INPUT_IMAGE_ORIENTATON-4" value="4"></aside></div>
<label class="input-header">IMAGE QUALITY (UNIT IN PERCENT)</label>
<div class="FORM_CONTAINER_INPUT"><input type="range" class="input-element input-range" name="INPUT_IMAGE_QUALITY" autocomplete="off" min="10" max="100" step="10" value="80"><input type="text" class="input-element input-range-value" name="INPUT_IMAGE_QUALITY" autocomplete="off" min="10" max="100" maxlength="5"></div>
<label class="input-header">IMAGE FORMAT</label>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_IMAGE_FORMAT-1">GRAPHICS INTERCHANGE FORMAT (GIF)</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_IMAGE_FORMAT" id="INPUT_IMAGE_FORMAT-1" value="1" checked></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_IMAGE_FORMAT-2">PORTABLE NETWORK GRAPHICS (PNG)</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_IMAGE_FORMAT" id="INPUT_IMAGE_FORMAT-2" value="2"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_IMAGE_FORMAT-3">JOINT PHOTOGRAPHIC EXPERTS GROUP (JPEG)</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_IMAGE_FORMAT" id="INPUT_IMAGE_FORMAT-3" value="3"></aside></div>
<label class="input-header">IMAGE OUTPUT</label>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_IMAGE_OUTPUT-1">DISPLAY THE IMAGE</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_IMAGE_OUTPUT" id="INPUT_IMAGE_OUTPUT-1" value="1" checked></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_IMAGE_OUTPUT-2">START A FILE DOWNLOAD</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_IMAGE_OUTPUT" id="INPUT_IMAGE_OUTPUT-2" value="2"></aside></div>
<div class="FORM_CONTAINER_INPUT"><label class="input-radio-label" for="INPUT_IMAGE_OUTPUT-3">SAVE THE IMAGE TO A FILE</label><aside class="input-radio-aside"><input type="radio" class="input-element input-radio" name="INPUT_IMAGE_OUTPUT" id="INPUT_IMAGE_OUTPUT-3" value="3"></aside></div>
<label class="input-header">FILE LOCATION (WRITE PERMISSIONS ARE REQUIRED)</label>
<input type="text" class="input-element input-text" name="INPUT_IMAGE_FILE_NAME" placeholder="DIR NAME / FILE NAME ..." autocomplete="off">
</form>

<form class="FORM_CONTAINER">
<label class="input-header">URL OF THE BARCODE CONFIGURATION </label>
<label class="label-text" name="BARCODE_CONFIGURATION"></label>
</form>

<form class="FORM_CONTAINER hidden">
<label class="input-header">CHECKBOX</label>
<div class="FORM_CONTAINER_INPUT"><label class="input-checkbox-label" for="TEST-1">CHECKBOX</label><aside class="input-checkbox-aside"><input type="checkbox" class="input-element input-checkbox" name="TEST" id="TEST-1" value="1"></aside></div>
</form>

<main class="page-main">
<div class="BARCODE_DISPLAY_AREA">
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

        document.getElementsByClassName('BARCODE_IMAGE')[0].src = './php-barcode.test.php?a=1' + BARCODE_URL;

        document.getElementsByName('BARCODE_CONFIGURATION')[0].innerHTML = BARCODE_URL;
    }

    //-------------------------------------------------
    // INPUT RANGE
    //-------------------------------------------------

    function INPUT_RANGE()
    {
        var a = document.getElementsByClassName('input-range');
        
        for ( var b = 0; b < a.length; b++ )
        {
            document.getElementsByName( a[b].name )[1].value = a[b].value;

            a[b].oninput = function(event)
            { 
                document.getElementsByName( this.name )[1].value = this.value;
            }
        }

        var a = document.getElementsByClassName('input-range-value');
        
        for ( var b = 0; b < a.length; b++ )
        {
            a[b].onkeyup = function(event)
            { 
                document.getElementsByName( this.name )[0].value = this.value;
            }
        }
    }
    INPUT_RANGE();

    //-------------------------------------------------
    // INPUT ELEMENT
    //-------------------------------------------------

    var a = document.getElementsByClassName('input-element');
    
    for ( var b = 0; b < a.length; b++ )
    {
        if ( a[b].type == 'text' || a[b].type == 'radio' && a[b].checked == true )
        {
            BARCODE_CONFIGURATION[ a[b].name ] = encodeURIComponent( a[b].value );
        }

        a[b].onchange = function(event)
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
        if ( typeof document.getElementsByName( BARCODE_KEY )[0] != 'undefined' )
        {
            document.getElementsByName( BARCODE_KEY )[0].value = BARCODE_VALUE;
        }

        if ( typeof document.getElementsByName( BARCODE_KEY )[1] != 'undefined' )
        {
            document.getElementsByName( BARCODE_KEY )[1].value = BARCODE_VALUE;
        }
        
        BARCODE_CONFIGURATION[ BARCODE_KEY ] = encodeURIComponent( BARCODE_VALUE );
    }

    //-------------------------------------------------
    // TEXTAREA RESIZE
    //-------------------------------------------------

    function TEXTAREA_RESIZE()
    {
        var a = document.getElementsByClassName('textarea-resize');
        
        for ( var b = 0; b < a.length; b++ )
        {
            a[b].style.height = a[b].scrollHeight + 'px';

            a[b].onkeyup = function(event)
            {
                this.style.height = this.scrollHeight + 'px';
            }
        }
    }
    TEXTAREA_RESIZE();

</script>