<?php
/**
 * Application: BarCode Coder Library (BCCL)
 *
 * @version 2.0.20
 * @package BCCL
 * @porting PHP
 *
 * @date    2013-01-06
 * @author  DEMONTE Jean-Baptiste <jbdemonte@gmail.com>
 * @author  HOUREZ Jonathan
 *
 * @date    2013-12-24
 *          Leszek Boroch <borek@borek.net.pl>
 *          Modification in class Barcode_Code128 to enable encoding extended characters
 *          (ASCII above 127). To use barcodes, keypad emulation must be enabled in scanner configuration
 *          (tested with Motorola/Symbol LS2208).
 *
 * @website http://barcode-coder.com/
 *
 * @licence http://www.cecill.info/licences/Licence_CeCILL_V2-fr.html
 * @licence http://www.gnu.org/licenses/gpl.html
 */

/**
 * Barcode Class
 *
 * @since   2.0.3
 * @package BCCL
 */
class Barcode
{
    /**
     * Contains the file name.
     *
     * @since   2.0.20
     * @access  protected
     *
     * @var     string
     */
    protected $file_name = '';

    /**
     * Contains the image resource.
     *
     * @since   2.0.7
     * @access  protected
     *
     * @var     null|resource
     */
    protected $image_resource = null;

    /**
     * With this value, the output quality is determined. The value can vary from 0 to 100.
     *
     * @since   2.0.8
     * @access  protected
     *
     * @var     integer
     */
    protected $image_quality = 100;

    /**
     * Specifies in which direction the image is to be displayed.
     *
     * @since   2.0.11
     * @access  protected
     *
     * @var     string
     */
    protected $image_orientaton = 'top';

    /**
     * Does the image width.
     *
     * @since   2.0.12
     * @access  protected
     *
     * @var     null|integer
     */
    protected $image_width = null;

    /**
     * Does the image height.
     *
     * @since   2.0.12
     * @access  protected
     *
     * @var     null|integer
     */
    protected $image_height = null;

    /**
     * Contains the allowed scales.
     *
     * @since   2.0.12
     * @access  protected
     *
     * @var     array
     */
    protected $array_of_allowed_image_scales = array( 'inch', 'in', 'cm', 'mm', 'pixels', 'px', 'points', 'pt' );

    /**
     * Contains the image format, after which the barcode is to be output.
     *
     * @since   2.0.7
     * @access  protected
     *
     * @var     string
     */
    protected $image_content_type = 'gif';

    /**
     * Contains the allowed image extensions.
     *
     * @since   2.0.7
     * @access  protected
     *
     * @var     array
     */
    protected $array_of_allowed_image_extensions = array( 'gif', 'jpg', 'jpeg', 'png' );

    /**
     * Does the color, which should be used in the preparation of a barcode module.
     *
     * @since   2.0.14
     * @access  protected
     *
     * @var     string
     */
    protected $image_barcode_module_color = '000000';

    /**
     * Does the color, which should be used when creating the image background.
     *
     * @since   2.0.14
     * @access  protected
     *
     * @var     string
     */
    protected $image_background_color = 'FFFFFF';

    /**
     * Contains the desired image width.
     *
     * @since   2.0.12
     * @access  protected
     *
     * @var     null|integer
     */
    protected $image_resize_width = null;

    /**
     * Contains the desired image height.
     *
     * @since   2.0.12
     * @access  protected
     *
     * @var     null|integer
     */
    protected $image_resize_height = null;

    /**
     * Contains the desired image scale.
     *
     * @since   2.0.12
     * @access  protected
     *
     * @var     null|string
     */
    protected $image_resize_scale = null;

    /**
     * Contains the desired dots per inch.
     *
     * @since   2.0.12
     * @access  protected
     *
     * @var     null|integer
     */
    protected $image_resize_dpi = null;

    /**
     * Contains the barcode type.
     *
     * @since   2.0.7
     * @access  protected
     *
     * @var     string
     */
    protected $barcode_type = 'qrcode';

    /**
     * Contains the barcode content.
     *
     * @since   2.0.7
     * @access  protected
     *
     * @var     string
     */
    protected $barcode_content = 'BarCode Coder Library';

    /**
     * Contains the barcode margin.
     *
     * @since   2.0.13
     * @access  protected
     *
     * @var     array
     */
    protected $barcode_margin = array( 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0 );

    /**
     * The check code for error detection and correction is as CRC, using polynomial division. (https://wikipedia.org/wiki/Cyclic_redundancy_check)
     *
     * @since   2.0.7
     * @access  protected
     *
     * @var     boolean
     */
    protected $barcode_cyclic_redundancy_check = true;

    /**
     * Determines whether the data matrix to display rectangle. (DIN 16587 Rectangular Extension of Data Matrix)
     *
     * @since   2.0.7
     * @access  protected
     *
     * @var     boolean
     */
    protected $barcode_datamatrix_rectangular = false;

    /**
     * Create an instance and processed the incoming arguments.
     *
     * @since   2.0.7
     * @access  public
     *
     * @return  Barcode
     */
    public function __construct()
    {
        $get_args = func_get_args();
        $num_args = func_num_args();

        if ( $num_args == 1 )
        {
            foreach ( $get_args[ 0 ] as $arg_index => $arg_value )
            {
                switch ( strtolower( $arg_index ) )
                {
                    case 'type':
                    {
                        $this->type( $arg_value );
                    }
                    break;
                    case 'content':
                    {
                        $this->content( $arg_value );
                    }
                    break;
                    case 'name':
                    {
                        $this->name( $arg_value );
                    }
                    break;
                    case 'extension':
                    {
                        $this->extension( $arg_value );
                    }
                    break;
                    case 'quality':
                    {
                        $this->quality( $arg_value );
                    }
                    break;
                    case 'margin':
                    {
                        $this->margin( $arg_value );
                    }
                    break;
                    case 'orientaton':
                    {
                        $this->orientaton( $arg_value );
                    }
                    break;
                    case 'width':
                    {
                        $this->width( $arg_value );
                    }
                    break;
                    case 'height':
                    {
                        $this->height( $arg_value );
                    }
                    break;
                    case 'scale':
                    {
                        $this->scale( $arg_value );
                    }
                    break;
                    case 'dpi':
                    {
                        $this->dpi( $arg_value );
                    }
                    break;
                    case 'crc':
                    {
                        $this->crc( $arg_value );
                    }
                    break;
                    case 'rect':
                    {
                        $this->rect( $arg_value );
                    }
                    break;
                    case 'color':
                    {
                        $this->color( $arg_value );
                    }
                    break;
                }
            }
        }
        else if ( $num_args == 2 )
        {
            $this->type( $get_args[ 0 ] )->content( $get_args[ 1 ] );
        }

        return $this;
    }

    /**
     * Destroy the image resource.
     *
     * @since   2.0.7
     * @access  public
     */
    public function __destruct()
    {
        if ( $this->image_resource !== null && get_resource_type( $this->image_resource ) === 'gd' )
        {
            imagedestroy( $this->image_resource );
        }
    }

    /**
     * Can be called to define the barcode type.
     *
     * @since   2.0.7
     * @access  public
     *
     * @param   null|string $value Contains the value of barcode type.
     *
     * @return  Barcode
     */
    public function type( $value = null )
    {
        if ( is_null( $value ) ): return $this->barcode_type; endif;

        $this->barcode_type = is_string( $value ) ? strtolower( $value ) : $this->barcode_type;

        return $this;
    }

    /**
     * Can be called to define the barcode content.
     *
     * @since   2.0.7
     * @access  public
     *
     * @param   null|string $value Contains the value of barcode content.
     *
     * @return  Barcode
     */
    public function content( $value = null )
    {
        if ( is_null( $value ) ): return $this->barcode_content; endif;

        $this->barcode_content = $value;

        return $this;
    }

    /**
     * Can be called to set a new file name.
     *
     * @since   2.0.20
     * @access  public
     *
     * @param   null|string $value Contains the value of file name.
     *
     * @return  Barcode
     */
    public function name( $value = null )
    {
        // if ( is_null( $value ) ): return $this->image_content_type; endif;

        // $this->image_content_type = in_array( $value, $this->array_of_allowed_image_extensions ) ? $value : $this->image_content_type;

        // if ( is_int( $this->barcode_content ) )
        // {
        //     echo 'nur zahlen'
        // }

        // $this->file_name = $value;

        // if ( is_string( $value ) && empty( $value ) == true ): $value = $this->file_name; endif;

        // if ( is_string( $value ) && strrpos( $value, '.' ) == false ): $value .= '.' . $this->image_content_type; endif;

        // if ( is_string( $value ) && is_writeable( dirname( $value ) ) == false ): throw new Exception( 'The specified file path (' . $value . ') is not writable.' ); endif;

        $this->file_name = 'BARCODE-' . strtoupper( $this->barcode_type ) . '-' . strtoupper( sha1( $this->barcode_content ) ) . '.' . $this->image_content_type;

        return $this;
    }

    /**
     * Can be called to set a new image extension.
     *
     * @since   2.0.20
     * @access  public
     *
     * @param   null|string $value Contains the value of image extension.
     *
     * @return  Barcode
     */
    public function extension( $value = null )
    {
        if ( is_null( $value ) ): return $this->image_content_type; endif;

        $this->image_content_type = in_array( $value, $this->array_of_allowed_image_extensions ) ? $value : $this->image_content_type;

        return $this;
    }

    /**
     * Can be called to change the image quality.
     *
     * @since   2.0.8
     * @access  public
     *
     * @param   null|integer $value Contains the value of image quality.
     *
     * @return  Barcode
     */
    public function quality( $value = null )
    {
        $this->image_quality = is_numeric( $value ) ? $value : $this->image_quality;

        return $this;
    }

    /**
     * Can be called to paint the barcode a white frame.
     *
     * @since   2.0.7
     * @access  public
     *
     * @param   null|integer Contains the value of margin.
     *
     * @return  Barcode
     */
    public function margin()
    {
        $get_args = func_get_args();
        $num_args = func_num_args();

        if ( $num_args == 1 )
        {
            $this->barcode_margin = array( 'top' => intval( $get_args[ 0 ] ), 'right' => intval( $get_args[ 0 ] ), 'bottom' => intval( $get_args[ 0 ] ), 'left' => intval( $get_args[ 0 ] ) );
        }
        else if ( $num_args == 2 )
        {
            $this->barcode_margin = array( 'top' => intval( $get_args[ 0 ] ), 'right' => intval( $get_args[ 1 ] ), 'bottom' => intval( $get_args[ 0 ] ), 'left' => intval( $get_args[ 1 ] ) );
        }
        else if ( $num_args == 4 )
        {
            $this->barcode_margin = array( 'top' => intval( $get_args[ 0 ] ), 'right' => intval( $get_args[ 1 ] ), 'bottom' => intval( $get_args[ 2 ] ), 'left' => intval( $get_args[ 3 ] ) );
        }

        return $this;
    }

    /**
     * Can be called to change the image width.
     *
     * @since   2.0.12
     * @access  public
     *
     * @param   null|integer $value Contains the value of image width.
     *
     * @return  Barcode
     */
    public function width( $value = null )
    {
        if ( is_null( $value ) ): return $this->image_width; endif;

        $this->image_resize_width = is_numeric( $value ) ? $value : $this->image_resize_width;

        return $this;
    }

    /**
     * Can be called to change the image height.
     *
     * @since   2.0.12
     * @access  public
     *
     * @param   null|integer $value Contains the value of image height.
     *
     * @return  Barcode
     */
    public function height( $value = null )
    {
        if ( is_null( $value ) ): return $this->image_height; endif;

        $this->image_resize_height = is_numeric( $value ) ? $value : $this->image_resize_height;

        return $this;
    }

    /**
     * Can be called to change the image scale.
     *
     * @since   2.0.12
     * @access  public
     *
     * @param   null|string $value Contains the value of image scale.
     *
     * @return  Barcode
     */
    public function scale( $value = null )
    {
        if ( is_null( $value ) ): return $this->image_resize_scale; endif;

        $this->image_resize_scale = in_array( $value, $this->array_of_allowed_image_scales ) ? $value : $this->image_resize_scale;

        return $this;
    }

    /**
     * Can be called to change the dots per inch.
     *
     * @since   2.0.12
     * @access  public
     *
     * @param   null|integer $value Contains the value of dots per inch.
     *
     * @return  Barcode
     */
    public function dpi( $value = null )
    {
        if ( is_null( $value ) ): return $this->image_resize_dpi; endif;

        $this->image_resize_dpi = is_numeric( $value ) ? $value : $this->image_resize_dpi;

        return $this;
    }

    /**
     * Can be called to determine whether a review should be carried out.
     *
     * @since   2.0.12
     * @access  public
     *
     * @param   null|boolean|integer|string $value Contains a value that is true.
     *
     * @return  Barcode
     */
    public function crc( $value = null )
    {
        $this->barcode_cyclic_redundancy_check = $value ? true : false;

        return $this;
    }

    /**
     * Can be called to determine the rectangular representation of a data matrix.
     *
     * @since   2.0.12
     * @access  public
     *
     * @param   null|boolean|integer|string $value Contains a value that is true.
     *
     * @return  Barcode
     */
    public function rect( $value = null )
    {
        $this->barcode_datamatrix_rectangular = $value ? true : false;

        return $this;
    }

    /**
     * Can be called to change the barcode module and the image background color.
     *
     * @since   2.0.14
     * @access  public
     *
     * @param   null|string Contains the value of color.
     *
     * @return  Barcode
     */
    public function color()
    {
        $get_args = func_get_args();
        $num_args = func_num_args();

        if ( $num_args == 1 )
        {
            $this->image_barcode_module_color = is_string( $get_args[ 0 ] ) ? $get_args[ 0 ] : $this->image_barcode_module_color;
        }
        else if ( $num_args == 2 )
        {
            $this->image_barcode_module_color = is_string( $get_args[ 0 ] ) ? $get_args[ 0 ] : $this->image_barcode_module_color;
            $this->image_background_color     = is_string( $get_args[ 1 ] ) ? $get_args[ 1 ] : $this->image_background_color;
        }

        return $this;
    }

    /**
     * Can be called to beautify the appearance of the barcode.
     *
     * @since   2.0.14
     * @access  public
     *
     * @param   null
     *
     * @return  Barcode
     */
    public function template()
    {
        $get_args = func_get_args();
        $num_args = func_num_args();

        // module_width

        // module_height

        // template_name

        // price_extention = true|false

        // text_position = top|bottom|both

        // barcode_deferrals = true|false

        //-------------------------------------------------
        // BARCODE DEFERRALS
        //-------------------------------------------------

        // $barcode_deferrals_8  = array( 0, 2, 32, 34, 64, 66 );
        // $barcode_deferrals_13 = array( 0, 2, 46, 48, 92, 94 );

        // if ( $this->barcode_type == 'ean8' && in_array( $module_x_index, $barcode_separations_8 ) )
        // {
        //     $new_module_height = $module_height + 6;
        // }
        // else if ( $this->barcode_type == 'ean13' && in_array( $module_x_index, $barcode_separations_13 ) )
        // {
        //     $new_module_height = $module_height + 6;
        // }
        // else if ( $this->barcode_type == 'upc' && in_array( $module_x_index, $barcode_separations_13 ) )
        // {
        //     $new_module_height = $module_height + 6;
        // }
        // else
        // {
        //     $new_module_height = $module_height;
        // }

        //-------------------------------------------------
        // EAN 8 + 13
        //-------------------------------------------------

        // BARCODE WITHOUT ALL.
        // BARCODE WITH TEXT_LABEL "EAN + CODE" OR "GTIN + CODE", POSITION = "DOWN | UP"
        // BARCODE WITH LONG LINES AND SAWN CODE, POSITION = "DOWN"
        // BARCODE WITH LONG LINES AND CODE SAWN AND TEXT_LABEL "ISSN | ISBN | ISMN", POSITION "UP & DOWN"

        // if ( $this->barcode_type == 'ean8' && preg_match( '/^([0-9]{4})([0-9]{4})$/', $this->barcode_content, $match ) )
        // {
        //     $string_x_start = $this->barcode_margin['left'] - 10;
        //     $string_y_start = $this->barcode_margin['top'] + $barcode_height - 2;

        //     imagestring( $this->image_resource, 2, $string_x_start + 3, $string_y_start, '<', $this->image_barcode_module_color );
        //     imagestring( $this->image_resource, 2, $string_x_start + 16, $string_y_start, $match[1], $this->image_barcode_module_color );
        //     imagestring( $this->image_resource, 2, $string_x_start + 48, $string_y_start, $match[2], $this->image_barcode_module_color );
        //     imagestring( $this->image_resource, 2, $string_x_start + 79, $string_y_start, '>', $this->image_barcode_module_color );
        // }

        // if ( $this->barcode_type == 'ean13' && preg_match( '/^([0-9]{1})([0-9]{6})([0-9]{6})$/', $this->barcode_content, $match ) )
        // {
        //     $string_x_start = $this->barcode_margin['left'] - 10;
        //     $string_y_start = $this->barcode_margin['top'] + $barcode_height - 2;

        //     imagestring( $this->image_resource, 2, $string_x_start + 3, $string_y_start, $match[1], $this->image_barcode_module_color );
        //     imagestring( $this->image_resource, 2, $string_x_start + 17, $string_y_start, $match[2], $this->image_barcode_module_color );
        //     imagestring( $this->image_resource, 2, $string_x_start + 63, $string_y_start, $match[3], $this->image_barcode_module_color );
        //     imagestring( $this->image_resource, 2, $string_x_start + 107, $string_y_start, '>', $this->image_barcode_module_color );
        // }

        //-------------------------------------------------
        // INTERNATIONAL STANDARD SERIAL NUMBER
        //-------------------------------------------------

        // if ( $this->barcode_type == 'ean13' && preg_match( '/^(977)([0-9]{1})([0-9]{5})([0-9]{3})([0-9]{1})$/', $this->barcode_content, $match ) )
        // {
        //     $string_x_start = $this->barcode_margin['left'] - 8;
        //     $string_y_start = $this->barcode_margin['top'] - 9;

        //     imagestring( $this->image_resource, 1, $string_x_start, $string_y_start, 'ISSN ' . $match[1] . '-' . $match[2] . '-' . $match[3] . '-' . $match[4] . '-' . $match[5], $this->image_barcode_module_color );
        // }

        //-------------------------------------------------
        // INTERNATIONAL STANDARD BOOK NUMBER
        //-------------------------------------------------

        // if ( $this->barcode_type == 'ean13' && preg_match( '/^(978|979)([0-9]{1})([0-9]{5})([0-9]{3})([0-9]{1})$/', $this->barcode_content, $match ) )
        // {
        //     $string_x_start = $this->barcode_margin['left'] - 8;
        //     $string_y_start = $this->barcode_margin['top'] - 9;

        //     imagestring( $this->image_resource, 1, $string_x_start, $string_y_start, 'ISBN ' . $match[1] . '-' . $match[2] . '-' . $match[3] . '-' . $match[4] . '-' . $match[5], $this->image_barcode_module_color );
        // }

        //-------------------------------------------------
        // INTERNATIONAL STANDARD MUSIC NUMBER
        //-------------------------------------------------

        // if ( $this->barcode_type == 'ean13' && preg_match( '/^(979)([0]{1})([0-9]{5})([0-9]{3})([0-9]{1})$/', $this->barcode_content, $match ) )
        // {
        //     $string_x_start = $this->barcode_margin['left'] - 8;
        //     $string_y_start = $this->barcode_margin['top'] - 9;

        //     imagestring( $this->image_resource, 1, $string_x_start, $string_y_start, 'ISMN ' . $match[1] . '-' . $match[2] . '-' . $match[3] . '-' . $match[4] . '-' . $match[5], $this->image_barcode_module_color );
        // }

        //-------------------------------------------------
        // UNIVERSAL PRODUCT CODE
        //-------------------------------------------------

        // BARCODE WITHOUT ALL.
        // BARCODE WITH TEXT_LABEL "UPC + CODE", POSITION "DOWN | UP"
        // BARCODE WITH LONG LINES AND SAWN CODE, POSITION "DOWN"

        // if ( $this->barcode_type == 'upc' && preg_match( '/^([0-9]{1})([0-9]{5})([0-9]{5})([0-9]{1})$/', $this->barcode_content, $match ) )
        // {
        //     $string_x_start = $this->barcode_margin['left'] - 10;
        //     $string_y_start = $this->barcode_margin['top'] + $barcode_height - 2;

        //     imagestring( $this->image_resource, 2, $string_x_start + 3, $string_y_start, $match[1], $this->image_barcode_module_color );
        //     imagestring( $this->image_resource, 2, $string_x_start + 20, $string_y_start, $match[2], $this->image_barcode_module_color );
        //     imagestring( $this->image_resource, 2, $string_x_start + 66, $string_y_start, $match[3], $this->image_barcode_module_color );
        //     imagestring( $this->image_resource, 2, $string_x_start + 107, $string_y_start, $match[4], $this->image_barcode_module_color );
        // }

        return $this;
    }

    /**
     * Created on the basis of the barcode data an image.
     *
     * @since   2.0.7
     * @access  public
     *
     * @return  Barcode
     * @throws  Exception
     */
    public function create()
    {
        if ( extension_loaded( 'gd' ) == false ): throw new Exception( 'The required extension GD is not loaded.' ); endif;

        switch ( strtoupper( $this->barcode_type ) )
        {
            case 'STD25':
            case 'INT25':
            {
                $array_of_modules = Barcode_Interleaved2of5::getDigit( $this->barcode_content, $this->barcode_cyclic_redundancy_check, $this->barcode_type );
            }
            break;
            case 'EAN':
            case 'GTIN':
            case 'EAN8':
            case 'GTIN8':
            case 'EAN13':
            case 'GTIN13':
            case 'ISSN':
            case 'ISBN':
            case 'ISMN':
            {
                $array_of_modules = Barcode_EuropeanArticleNumber::getDigit( $this->barcode_content, $this->barcode_type );
            }
            break;
            case 'UPC':
            case 'GTIN12':
            {
                $array_of_modules = Barcode_UniversalProductCode::getDigit( $this->barcode_content );
            }
            break;
            case 'CODE11':
            {
                $array_of_modules = Barcode_Code11::getDigit( $this->barcode_content );
            }
            break;
            case 'CODE39':
            {
                $array_of_modules = Barcode_Code39::getDigit( $this->barcode_content );
            }
            break;
            case 'CODE93':
            {
                $array_of_modules = Barcode_Code93::getDigit( $this->barcode_content, $this->barcode_cyclic_redundancy_check );
            }
            break;
            case 'CODE128':
            {
                $array_of_modules = Barcode_Code128::getDigit( $this->barcode_content );
            }
            break;
            case 'CODABAR':
            {
                $array_of_modules = Barcode_Codabar::getDigit( $this->barcode_content );
            }
            break;
            case 'MSI':
            {
                $array_of_modules = Barcode_ModifiedPlessey::getDigit( $this->barcode_content, $this->barcode_cyclic_redundancy_check );
            }
            break;
            case 'DATAMATRIX':
            {
                $array_of_modules = Barcode_DataMatrix::getDigit( $this->barcode_content, $this->barcode_datamatrix_rectangular );
            }
            break;
            case 'QRCODE':
            {
                $a = new Barcode_QuickResponseCode( $this->barcode_content, 3 );
                $array_of_modules = $a->getDigit();
            }
            break;
            default:
            {
                throw new Exception( 'The required barcode class were not found.' );
            }
        }

        if ( empty( $array_of_modules ) ): throw new Exception( 'The contents could not be processed.' ); endif;

        if ( is_array( $array_of_modules ) == false ): $array_of_modules = array( str_split( $array_of_modules ) ); endif;

        //-------------------------------------------------
        // Generate widths, heights and coordinates.
        //-------------------------------------------------

        $angle = deg2rad( -0 );

        $angle_cos = cos( $angle );
        $angle_sin = sin( $angle );

        $module_x_count = is_string( $array_of_modules[ 0 ] ) ? strlen( $array_of_modules[ 0 ] ) : count( $array_of_modules[ 0 ] );
        $module_y_count = count( $array_of_modules );

        $module_width  = 1;
        $module_height = $this->barcode_type == 'datamatrix' || $this->barcode_type == 'qrcode' ? 1 : 40;

        $barcode_width  = $module_x_count * $module_width;
        $barcode_height = $module_y_count * $module_height;

        $this->image_width  = $this->barcode_margin[ 'left' ] + $barcode_width  + $this->barcode_margin[ 'right' ];
        $this->image_height = $this->barcode_margin[ 'top' ]  + $barcode_height + $this->barcode_margin[ 'bottom' ];

        //-------------------------------------------------
        // Generate the image resource.
        //-------------------------------------------------

        $this->image_resource = imagecreatetruecolor( $this->image_width, $this->image_height );

        //-------------------------------------------------
        // Preparation of color.
        //-------------------------------------------------

        if ( preg_match( '/^(?P<red>[0-9a-fA-F]{2})(?P<green>[0-9a-fA-F]{2})(?P<blue>[0-9a-fA-F]{2})$/', $this->image_barcode_module_color, $match ) )
        {
            $this->image_barcode_module_color = imagecolorallocate( $this->image_resource, hexdec( $match[ 'red' ] ), hexdec( $match[ 'green' ] ), hexdec( $match[ 'blue' ] ) );
        }

        if ( preg_match( '/^(?P<red>[0-9a-fA-F]{2})(?P<green>[0-9a-fA-F]{2})(?P<blue>[0-9a-fA-F]{2})$/', $this->image_background_color, $match ) )
        {
            $this->image_background_color = imagecolorallocate( $this->image_resource, hexdec( $match[ 'red' ] ), hexdec( $match[ 'green' ] ), hexdec( $match[ 'blue' ] ) );
        }

        if ( is_int( $this->image_barcode_module_color ) == false || is_int( $this->image_background_color ) == false )
        {
            throw new Exception( 'The selected color could not be processed correctly.' );
        }

        imagefilledrectangle( $this->image_resource, 0, 0, $this->image_width, $this->image_height, $this->image_background_color );

        //-------------------------------------------------
        // Draw the rectangles.
        //-------------------------------------------------

        for ( $module_y_index = 0; $module_y_index < $module_y_count; $module_y_index++ )
        {
            for ( $module_x_index = 0; $module_x_index < $module_x_count; $module_x_index++ )
            {
                if ( $array_of_modules[ $module_y_index ][ $module_x_index ] )
                {
                    if ( $this->barcode_type == 'datamatrix' || $this->barcode_type == 'qrcode' )
                    {
                        imagesetpixel( $this->image_resource, $this->barcode_margin[ 'left' ] + $module_x_index, $this->barcode_margin[ 'top' ] + $module_y_index, $this->image_barcode_module_color );
                    }
                    else
                    {
                        $rectangle_x_start = $module_x_index * $module_width;
                        $rectangle_y_start = $module_y_index * $module_height;

                        $rectangle_x_end = ( $module_x_index + 0.999 ) * $module_width;
                        $rectangle_y_end = ( $module_y_index + 0.999 ) * $module_height;

                        self::_rotate( $rectangle_x_start, $rectangle_y_start, $angle_cos, $angle_sin, $point_a_x, $point_a_y );
                        self::_rotate( $rectangle_x_end,   $rectangle_y_start, $angle_cos, $angle_sin, $point_b_x, $point_b_y );
                        self::_rotate( $rectangle_x_end,   $rectangle_y_end,   $angle_cos, $angle_sin, $point_c_x, $point_c_y );
                        self::_rotate( $rectangle_x_start, $rectangle_y_end,   $angle_cos, $angle_sin, $point_d_x, $point_d_y );

                        $array_of_coordinates = array();

                        array_push( $array_of_coordinates, $this->barcode_margin[ 'left' ] + $point_a_x, $this->barcode_margin[ 'top' ] + $point_a_y );
                        array_push( $array_of_coordinates, $this->barcode_margin[ 'left' ] + $point_b_x, $this->barcode_margin[ 'top' ] + $point_b_y );
                        array_push( $array_of_coordinates, $this->barcode_margin[ 'left' ] + $point_c_x, $this->barcode_margin[ 'top' ] + $point_c_y );
                        array_push( $array_of_coordinates, $this->barcode_margin[ 'left' ] + $point_d_x, $this->barcode_margin[ 'top' ] + $point_d_y );

                        imagefilledpolygon( $this->image_resource, $array_of_coordinates, 4, $this->image_barcode_module_color );
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Can be called to change the image from outside the class.
     *
     * Checks the modified resource and processes them.
     *
     * @since   2.0.8
     * @access  public
     *
     * @param   null|resource
     *
     * @return  Barcode|resource
     */
    public function resource( $image_resource = null )
    {
        if ( is_resource( $image_resource ) )
        {
            $this->image_resource = $image_resource;

            return $this;
        }
        else
        {
            if ( is_resource( $this->image_resource ) == false ): $this->create(); endif;

            return $this->image_resource;
        }
    }

    /**
     * Can be called to change the orientation.
     *
     * @since   2.0.11
     * @access  public
     *
     * @param   string $value Contains the value of orientation.
     *
     * @return  Barcode
     */
    public function orientaton( $value = null )
    {
        if ( is_resource( $this->image_resource ) == false ): $this->create(); endif;

        $this->image_orientaton = empty( $value ) == false ? $value : $this->image_orientaton;

        switch ( $this->image_orientaton )
        {
            default:
            case 'top':
            {
                // $this->image_orientaton = 0; The default value causes the image to be blurred.
            }
            break;
            case 'right':
            {
                $this->image_orientaton = 270;
            }
            break;
            case 'bottom':
            {
                $this->image_orientaton = 180;
            }
            break;
            case 'left':
            {
                $this->image_orientaton = 90;
            }
            break;
        }

        if ( is_int( $this->image_orientaton ) )
        {
            $this->image_resource = imagerotate( $this->image_resource, $this->image_orientaton, $this->image_background_color );

            $this->image_width  = imagesx( $this->image_resource );
            $this->image_height = imagesy( $this->image_resource );
        }

        return $this;
    }

    /**
     * Can be called to enlarge a barcode to a certain size.
     *
     * @since   2.0.12
     * @access  public
     *
     * @param   integer #1 Contains the value of image width.
     * @param   integer #2 Contains the value of image height.
     * @param   string  #3 Contains the value of scale.
     * @param   integer #4 Contains the value of dots per inch.
     *
     * @return  Barcode
     * @throws  Exception
     */
    public function resize()
    {
        if ( is_resource( $this->image_resource ) == false ): $this->create(); endif;

        $get_args = func_get_args();
        $num_args = func_num_args();

        if ( $num_args == 1 && is_int( $get_args[ 0 ] ) && $get_args[ 0 ] > 100 )
        {
            $this->image_resize_width  = $this->image_width  * $get_args[ 0 ] / 100;
            $this->image_resize_height = $this->image_height * $get_args[ 0 ] / 100;
        }
        else if ( $num_args == 1 && is_string( $get_args[ 0 ] ) )
        {
            // TODO: More templates process.
            // $get_args[ 0 ] = 'Draw a picture of 100 to 99 in inch with 90 dpi.';
            // $get_args[ 0 ] = '100 x 99 [ SCALE ] 90 [ DPI ]';
            // $get_args[ 0 ] = '100 x 99 inch 90 dpi';
            // $get_args[ 0 ] = '100x99inch90dpi';
            // $get_args[ 0 ] = '100,99,inch,90';
            // $get_args[ 0 ] = '100x99';
            // $get_args[ 0 ] = '100,99';
            // $get_args[ 0 ] = '100 99';

            if ( preg_match( '/(?P<width>\d+)x(?P<height>\d+)(?P<scale>' . implode( '|', $this->array_of_allowed_image_scales ) . ')(?P<dpi>\d+)/', $get_args[ 0 ], $match ) )
            {
                $this->width( $match[ 'width' ] )->height( $match[ 'height' ] )->scale( $match[ 'scale' ] )->dpi( $match[ 'dpi' ] );
            }
        }
        else if ( $num_args == 1 && is_array( $get_args[ 0 ] ) )
        {
            foreach ( $get_args[ 0 ] as $arg_index => $arg_value )
            {
                switch ( strtolower( $arg_index ) )
                {
                    case 'width':
                    {
                        $this->width( $arg_value );
                    }
                    break;
                    case 'height':
                    {
                        $this->height( $arg_value );
                    }
                    break;
                    case 'scale':
                    {
                        $this->scale( $arg_value );
                    }
                    break;
                    case 'dpi':
                    {
                        $this->dpi( $arg_value );
                    }
                    break;
                }
            }
        }
        else if ( $num_args == 4 )
        {
            $this->width( $get_args[ 0 ] )->height( $get_args[ 1 ] )->scale( $get_args[ 2 ] )->dpi( $get_args[ 3 ] );
        }

        switch ( $this->image_resize_scale )
        {
            case 'inch':
            case 'in':
            {
                $this->image_resize_width  = $this->image_resize_width  * $this->image_resize_dpi / 1;
                $this->image_resize_height = $this->image_resize_height * $this->image_resize_dpi / 1;
            }
            break;
            case 'cm':
            {
                $this->image_resize_width  = $this->image_resize_width  * $this->image_resize_dpi / 2.54;
                $this->image_resize_height = $this->image_resize_height * $this->image_resize_dpi / 2.54;
            }
            break;
            case 'mm':
            {
                $this->image_resize_width  = $this->image_resize_width  * $this->image_resize_dpi / 254;
                $this->image_resize_height = $this->image_resize_height * $this->image_resize_dpi / 254;
            }
            break;
        }

        if ( is_null( $this->image_resize_width ) || is_null( $this->image_resize_height ) )
        {
            return $this;
        }

        $new_image_resource = imagecreatetruecolor( $this->image_resize_width, $this->image_resize_height );

        if ( imagecopyresampled( $new_image_resource, $this->image_resource, 0, 0, 0, 0, $this->image_resize_width, $this->image_resize_height, $this->image_width, $this->image_height ) === false )
        {
            throw new Exception( 'When creating the preview image an error has occurred.' );
        }

        imagedestroy( $this->image_resource );

        $this->image_resource = $new_image_resource;

        $this->image_width  = $this->image_resize_width;
        $this->image_height = $this->image_resize_height;

        return $this;
    }

    /**
     * Check if the function "create" has been called, if not, then call.
     *
     * Say to the header, that the following data, will be an image and paint the image.
     *
     * @since   2.0.7
     * @access  public
     *
     * @param   null|boolean|string $value If the value is true, then deliver the image data to a variable. If the value is false, then start a file download. If the value is a string, then save the image to a file. If the filename is empty, then use the automatically generated.
     *
     * @return  string Does the image data, if the variable "$value" is true.
     * @throws  Exception
     */
    public function image( $value = null )
    {
        if ( is_resource( $this->image_resource ) == false ): $this->create(); endif;

        if ( empty( $this->file_name ) ): $this->name(); endif;

        if ( $value === null || $value === false )
        {
            header( 'Content-Type: image/' . $this->image_content_type );

            header( 'Content-Disposition: ' . ( $value === false ? 'attachment;' : '' ) . 'filename="' . $this->file_name . '"' );

            header( 'Cache-Control: no-cache, no-store, must-revalidate' );

            header( 'Pragma: no-cache' );

            header( 'Expires: 0' );
        }

        if ( $value === true ): ob_start(); endif;

        if ( function_exists( 'imagegif' ) && $this->image_content_type == 'gif' )
        {
            imagegif( $this->image_resource, is_string( $value ) ? $this->file_name : null );
        }
        else if ( function_exists( 'imagejpeg' ) && $this->image_content_type == 'jpg' || $this->image_content_type == 'jpeg' )
        {
            imageinterlace( $this->image_resource, true );

            imagejpeg( $this->image_resource, is_string( $value ) ? $this->file_name : null, round( $this->image_quality ) );
        }
        else if ( function_exists( 'imagepng' ) && $this->image_content_type == 'png' )
        {
            imagepng( $this->image_resource, is_string( $value ) ? $this->file_name : null, round( 9 * $this->image_quality / 100 ) );
        }
        else
        {
            throw new Exception( 'On this server, there is no supported image formats.' );
        }

        if ( $value === true )
        {
            $image_data = ob_get_contents();

            ob_end_clean();

            return $image_data;
        }
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function gd( $image_resource, $color, $x, $y, $angle, $type, $datas, $width = null, $height = null )
    {
        return self::_draw( __FUNCTION__, $image_resource, $color, $x, $y, $angle, $type, $datas, $width, $height );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function fpdf( $image_resource, $color, $x, $y, $angle, $type, $datas, $width = null, $height = null )
    {
        return self::_draw( __FUNCTION__, $image_resource, $color, $x, $y, $angle, $type, $datas, $width, $height );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function raw( $type, $datas )
    {
        $digit = '';
        $hri   = '';
        $code  = '';
        $crc   = true;
        $rect  = false;

        if ( is_array( $datas ) )
        {
            foreach ( array( 'code' => '', 'crc' => true, 'rect' => false ) as $v => $def )
            {
                $$v = isset( $datas[ $v ] ) ? $datas[ $v ] : $def;
            }

            $code = $code;
        }
        else
        {
            $code = $datas;
        }

        if ( $code == '' ) return false;

        $code = ( string ) $code;

        $type = strtolower( $type );

        switch ( $type )
        {
            case 'std25':
            case 'int25':
            $digit = Barcode_Interleaved2of5::getDigit( $code, $crc, $type );
            $hri = Barcode_Interleaved2of5::compute( $code, $crc, $type );
            break;
            case 'ean8':
            case 'ean13':
            $digit = Barcode_EuropeanArticleNumber::getDigit( $code, $type );
            $hri = Barcode_EuropeanArticleNumber::compute( $code, $type );
            break;
            case 'upc':
            $digit = Barcode_UniversalProductCode::getDigit( $code );
            $hri = Barcode_UniversalProductCode::compute( $code );
            break;
            case 'code11':
            $digit = Barcode_Code11::getDigit( $code );
            $hri = $code;
            break;
            case 'code39':
            $digit = Barcode_Code39::getDigit( $code );
            $hri = $code;
            break;
            case 'code93':
            $digit = Barcode_Code93::getDigit( $code, $crc );
            $hri = $code;
            break;
            case 'code128':
            $digit = Barcode_Code128::getDigit( $code );
            $hri = $code;
            break;
            case 'codabar':
            $digit = Barcode_Codabar::getDigit( $code );
            $hri = $code;
            break;
            case 'msi':
            $digit = Barcode_ModifiedPlessey::getDigit( $code, $crc );
            $hri = Barcode_ModifiedPlessey::compute( $code, $crc );
            break;
            case 'datamatrix':
            $digit = Barcode_DataMatrix::getDigit( $code, $rect );
            $hri = $code;
            break;
        }

        return array( $digit, $hri );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.4
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function _draw( $call, $res, $color, $x, $y, $angle, $type, $datas, $width, $height )
    {
        $digit = '';
        $hri   = '';

        list( $digit, $hri ) = self::raw( $type, $datas );

        $type = strtolower( $type );

        if ( $digit == '' ) return false;

        if ( $type == 'datamatrix' )
        {
            $width = is_null( $width ) ? 5 : $width;
            $height = $width;
        }
        else
        {
            $width = is_null( $width ) ? 1 : $width;
            $height = is_null( $height ) ? 50 : $height;

            $digit = self::bitStringTo2DArray( $digit );
        }

        if ( $call == 'gd' )
        {
            $result = self::digitToGDRenderer( $res, $color, $x, $y, $angle, $width, $height, $digit );
        }
        else if ( $call == 'fpdf' )
        {
            $result = self::digitToFPDFRenderer( $res, $color, $x, $y, $angle, $width, $height, $digit );
        }

        $result[ 'hri' ] = $hri;

        return $result;
    }

    /**
     * Convert a bit string to an array of array of bit char
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function bitStringTo2DArray( $digit )
    {
        $d = array();

        $len = strlen( $digit );

        for ( $i = 0; $i < $len; $i++ )
        {
            $d[ $i ] = $digit[ $i ];
        }

        return array( $d );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function digitToRenderer( $fn, $xi, $yi, $angle, $mw, $mh, $digit )
    {
        $lines = count( $digit );

        $columns = count( $digit[ 0 ] );

        $angle = deg2rad( -$angle );

        $cos = cos( $angle );

        $sin = sin( $angle );

        self::_rotate( $columns * $mw / 2, $lines * $mh / 2, $cos, $sin , $x, $y );

        $xi -= $x;
        $yi -= $y;

        for ( $y = 0; $y < $lines; $y++ )
        {
            $x = -1;

            while ( $x < $columns )
            {
                $x++;

                if ( isset( $digit[ $y ][ $x ] ) && $digit[ $y ][ $x ] == '1' )
                {
                    $z = $x;

                    while ( ( $z + 1 < $columns ) && ( $digit[ $y ][ $z + 1 ] == '1' ) )
                    {
                        $z++;
                    }

                    $x1 = $x * $mw;
                    $y1 = $y * $mh;

                    $x2 = ( $z + 1 ) * $mw;
                    $y2 = ( $y + 1 ) * $mh;

                    self::_rotate( $x1, $y1, $cos, $sin, $xA, $yA );
                    self::_rotate( $x2, $y1, $cos, $sin, $xB, $yB );
                    self::_rotate( $x2, $y2, $cos, $sin, $xC, $yC );
                    self::_rotate( $x1, $y2, $cos, $sin, $xD, $yD );

                    $fn( array( $xA + $xi, $yA + $yi, $xB + $xi, $yB + $yi, $xC + $xi, $yC + $yi, $xD + $xi, $yD + $yi ) );

                    $x = $z + 1;
                }
            }
        }

        return self::result( $xi, $yi, $columns, $lines, $mw, $mh, $cos, $sin );
    }

    /**
     * GD barcode renderer
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function digitToGDRenderer( $image_resource, $color, $xi, $yi, $angle, $mw, $mh, $digit )
    {
        $fn = function( $points ) use ( $image_resource, $color )
        {
            imagefilledpolygon( $image_resource, $points, 4, $color );
        };

        return self::digitToRenderer( $fn, $xi, $yi, $angle, $mw, $mh, $digit );
    }

    /**
     * FPDF barcode renderer
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function digitToFPDFRenderer( $pdf, $color, $xi, $yi, $angle, $mw, $mh, $digit )
    {
        if ( ! is_array( $color ) )
        {
            if ( preg_match( '`([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})`i', $color, $match ) )
            {
                $color = array( hexdec( $match[ 1 ] ), hexdec( $match[ 2 ] ), hexdec( $match[ 3 ] ) );
            }
            else
            {
                $color = array( 0, 0, 0 );
            }
        }

        $color = array_values( $color );

        $pdf->SetDrawColor( $color[ 0 ], $color[ 1 ], $color[ 2 ] );
        $pdf->SetFillColor( $color[ 0 ], $color[ 1 ], $color[ 2 ] );

        $fn = function( $points ) use ( $pdf )
        {
            $op = 'f';

            $h = $pdf->h;
            $k = $pdf->k;

            $points_string = '';

            for ( $i = 0; $i < 8; $i += 2 )
            {
                $points_string .= sprintf( '%.2F %.2F', $points[ $i ] * $k, ( $h - $points[ $i + 1 ] ) * $k );
                $points_string .= $i ? ' l ' : ' m ';
            }

            $pdf->_out( $points_string . $op );
        };

        return self::digitToRenderer( $fn, $xi, $yi, $angle, $mw, $mh, $digit );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function result( $xi, $yi, $columns, $lines, $mw, $mh, $cos, $sin )
    {
        self::_rotate( 0, 0, $cos, $sin , $x1, $y1 );
        self::_rotate( $columns * $mw, 0, $cos, $sin , $x2, $y2 );
        self::_rotate( $columns * $mw, $lines * $mh, $cos, $sin , $x3, $y3 );
        self::_rotate( 0, $lines * $mh, $cos, $sin , $x4, $y4 );

        return array( 'width' => $columns * $mw, 'height' => $lines * $mh, 'p1' => array( 'x' => $xi + $x1, 'y' => $yi + $y1 ), 'p2' => array( 'x' => $xi + $x2, 'y' => $yi + $y2 ), 'p3' => array( 'x' => $xi + $x3, 'y' => $yi + $y3 ), 'p4' => array( 'x' => $xi + $x4, 'y' => $yi + $y4 ) );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function _rotate( $x1, $y1, $cos, $sin , &$x, &$y )
    {
        $x = $x1 * $cos - $y1 * $sin;
        $y = $x1 * $sin + $y1 * $cos;
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function rotate( $x1, $y1, $angle , &$x, &$y )
    {
        $angle = deg2rad( -$angle );

        $cos = cos( $angle );
        $sin = sin( $angle );

        $x = $x1 * $cos - $y1 * $sin;
        $y = $x1 * $sin + $y1 * $cos;
    }
}

/**
 * Barcode_Interleaved2of5 Class
 *
 * @since   2.0.3
 * @package BCCL
 */
class Barcode_Interleaved2of5
{
    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @var     array
     */
    private static $encoding = array( 'NNWWN', 'WNNNW', 'NWNNW', 'WWNNN', 'NNWNW', 'WNWNN', 'NWWNN', 'NNNWW', 'WNNWN', 'NWNWN' );

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function compute( $code, $crc, $type )
    {
        if ( ! $crc )
        {
            if ( strlen( $code ) % 2 )
            {
                $code = '0' . $code;
            }
        }
        else
        {
            if ( ( $type == 'int25' ) && ( strlen( $code ) % 2 == 0 ) )
            {
                $code = '0' . $code;
            }

            $odd = true;

            $sum = 0;

            for ( $i = strlen( $code ) - 1; $i >- 1; $i-- )
            {
                $v = intval( $code[ $i ] );

                $sum += $odd ? 3 * $v : $v;

                $odd = ! $odd;
            }

            $code .= ( string ) ( ( 10 - $sum % 10 ) % 10 );
        }

        return $code;
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getDigit( $code, $crc, $type )
    {
        $code = self::compute( $code, $crc, $type );

        if ( $code == '' )
        {
            return $code;
        }

        $result = '';

        if ( $type == 'int25' )
        {
            //-------------------------------------------------
            // Interleaved 2 of 5
            //-------------------------------------------------

            //-------------------------------------------------
            // start
            //-------------------------------------------------

            $result .= '1010';

            //-------------------------------------------------
            // digits + CRC
            //-------------------------------------------------

            $end = strlen( $code ) / 2;

            for ( $i = 0; $i < $end; $i++ )
            {
                $c1 = $code[ 2 * $i ];
                $c2 = $code[ 2 * $i + 1 ];

                for ( $j = 0; $j < 5; $j++ )
                {
                    $result .= '1';

                    if ( self::$encoding[ $c1 ][ $j ] == 'W' )
                    {
                        $result .= '1';
                    }

                    $result .= '0';

                    if ( self::$encoding[ $c2 ][ $j ] == 'W' )
                    {
                        $result .= '0';
                    }
                }
            }

            //-------------------------------------------------
            // stop
            //-------------------------------------------------

            $result .= '1101';
        }
        else if ( $type == 'std25' )
        {
            // Standard 2 of 5 is a numeric-only barcode that has been in use a long time.
            // Unlike Interleaved 2 of 5, all of the information is encoded in the bars; the spaces are fixed width and are used only to separate the bars.
            // The code is self-checking and does not include a checksum.

            //-------------------------------------------------
            // start
            //-------------------------------------------------

            $result .= '11011010';

            //-------------------------------------------------
            // digits + CRC
            //-------------------------------------------------

            $end = strlen( $code );

            for ( $i = 0; $i < $end; $i++ )
            {
                $c = $code[ $i ];

                for ( $j = 0; $j < 5; $j++ )
                {
                    $result .= '1';

                    if ( self::$encoding[ $c ][ $j ] == 'W' )
                    {
                        $result .= '11';
                    }

                    $result .= '0';
                }
            }

            //-------------------------------------------------
            // stop
            //-------------------------------------------------

            $result .= '11010110';
        }

        return $result;
    }
}

/**
 * Barcode_EuropeanArticleNumber Class
 *
 * @since   2.0.3
 * @package BCCL
 */
class Barcode_EuropeanArticleNumber
{
    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @var     array
     */
    private static $encoding = array( array( '0001101', '0100111', '1110010' ), array( '0011001', '0110011', '1100110' ), array( '0010011', '0011011', '1101100' ), array( '0111101', '0100001', '1000010' ), array( '0100011', '0011101', '1011100' ), array( '0110001', '0111001', '1001110' ), array( '0101111', '0000101', '1010000' ), array( '0111011', '0010001', '1000100' ), array( '0110111', '0001001', '1001000' ), array( '0001011', '0010111', '1110100' ) );

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @var     array
     */
    private static $first = array( '000000', '001011', '001101', '001110', '010011', '011001', '011100', '010101', '010110', '011010' );

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getDigit( $code, $type )
    {
        //-------------------------------------------------
        // Check len ( 12 for ean13, 7 for ean8 )
        //-------------------------------------------------

        $len = $type == 'ean8' ? 7 : 12;

        $code = substr( $code, 0, $len );

        if ( ! preg_match( '`[0-9]{' . $len . '}`', $code ) ) return '';

        //-------------------------------------------------
        // get checksum
        //-------------------------------------------------

        $code = self::compute( $code, $type );

        //-------------------------------------------------
        // process analyse
        //-------------------------------------------------

        //-------------------------------------------------
        // start
        //-------------------------------------------------

        $result = '101';

        if ( $type == 'ean8' )
        {
            //-------------------------------------------------
            // process left part
            //-------------------------------------------------

            for ( $i = 0; $i < 4; $i++ )
            {
                $result .= self::$encoding[ intval( $code[ $i ] ) ][ 0 ];
            }

            //-------------------------------------------------
            // center guard bars
            //-------------------------------------------------

            $result .= '01010';

            //-------------------------------------------------
            // process right part
            //-------------------------------------------------

            for ( $i = 4; $i < 8; $i++ )
            {
                $result .= self::$encoding[ intval( $code[ $i ] ) ][ 2 ];
            }
        }
        else
        {
            //-------------------------------------------------
            // ean 13
            //-------------------------------------------------

            //-------------------------------------------------
            // extract first digit and get sequence
            //-------------------------------------------------

            $seq = self::$first[ intval( $code[ 0 ] ) ];

            //-------------------------------------------------
            // process left part
            //-------------------------------------------------

            for ( $i = 1; $i < 7; $i++ )
            {
                $result .= self::$encoding[ intval( $code[ $i ] ) ][ intval( $seq[ $i - 1 ] ) ];
            }

            //-------------------------------------------------
            // center guard bars
            //-------------------------------------------------

            $result .= '01010';

            //-------------------------------------------------
            // process right part
            //-------------------------------------------------

            for ( $i = 7; $i < 13; $i++ )
            {
                $result .= self::$encoding[ intval( $code[ $i ] ) ][ 2 ];
            }
        }

        //-------------------------------------------------
        // stop
        //-------------------------------------------------

        $result .= '101';

        return $result;
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function compute( $code, $type )
    {
        $len = $type == 'ean13' ? 12 : 7;

        $code = substr( $code, 0, $len );

        if ( ! preg_match( '`[0-9]{' . $len . '}`', $code ) ) return '';

        $sum = 0;

        $odd = true;

        for ( $i = $len - 1; $i >- 1; $i-- )
        {
            $sum += ( $odd ? 3 : 1 ) * intval( $code[ $i ] );

            $odd = ! $odd;
        }

        return $code . ( ( string ) ( ( 10 - $sum % 10 ) % 10 ) );
    }
}

/**
 * Barcode_UniversalProductCode Class
 *
 * @since   2.0.3
 * @package BCCL
 */
class Barcode_UniversalProductCode
{
    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getDigit( $code )
    {
        if ( strlen( $code ) < 12 )
        {
            $code = '0' . $code;
        }

        return Barcode_EuropeanArticleNumber::getDigit( $code, 'ean13' );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function compute( $code )
    {
        if ( strlen( $code ) < 12 )
        {
            $code = '0' . $code;
        }

        return substr( Barcode_EuropeanArticleNumber::compute( $code, 'ean13' ), 1 );
    }
}

/**
 * Barcode_ModifiedPlessey Class
 *
 * @since   2.0.3
 * @package BCCL
 */
class Barcode_ModifiedPlessey
{
    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @var     array
     */
    private static $encoding = array( '100100100100', '100100100110', '100100110100', '100100110110', '100110100100', '100110100110', '100110110100', '100110110110', '110100100100', '110100100110' );

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function compute( $code, $crc )
    {
        if ( is_array( $crc ) )
        {
            if ( $crc[ 'crc1' ] == 'mod10' )
            {
                $code = self::computeMod10( $code );
            }
            else if ( $crc[ 'crc1' ] == 'mod11' )
            {
                $code = self::computeMod11( $code );
            }
            if ( $crc[ 'crc2' ] == 'mod10' )
            {
                $code = self::computeMod10( $code );
            }
            else if ( $crc[ 'crc2' ] == 'mod11' )
            {
                $code = self::computeMod11( $code );
            }
        }
        else if ( $crc )
        {
            $code = self::computeMod10( $code );
        }

        return $code;
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function computeMod10( $code )
    {
        $len = strlen( $code );

        $toPart1 = $len % 2;

        $n1 = 0;

        $sum = 0;

        for ( $i = 0; $i < $len; $i++ )
        {
            if ( $toPart1 )
            {
                $n1 = 10 * $n1 + intval( $code[ $i ] );
            }
            else
            {
                $sum += intval( $code[ $i ] );
            }

            $toPart1 = ! $toPart1;
        }

        $s1 = ( string ) ( 2 * $n1 );

        $len = strlen( $s1 );

        for ( $i = 0; $i < $len; $i++ )
        {
            $sum += intval( $s1[ $i ] );
        }

        return $code . ( ( string ) ( 10 - $sum % 10 ) % 10 );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function computeMod11( $code )
    {
        $sum = 0;

        $weight = 2;

        for ( $i = strlen( $code ) - 1; $i >- 1; $i-- )
        {
            $sum += $weight * intval( $code[ $i ] );

            $weight = $weight == 7 ? 2 : $weight + 1;
        }

        return $code . ( ( string ) ( 11 - $sum % 11 ) % 11 );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getDigit( $code, $crc )
    {
        if ( preg_match( '`[^0-9]`', $code ) ) return '';

        $index = 0;

        $result = '';

        $code = self::compute( $code, false );

        //-------------------------------------------------
        // start
        //-------------------------------------------------

        $result = '110';

        //-------------------------------------------------
        // digits
        //-------------------------------------------------

        $len = strlen( $code );

        for ( $i = 0; $i < $len; $i++ )
        {
            $result .= self::$encoding[ intval( $code[ $i ] ) ];
        }

        //-------------------------------------------------
        // stop
        //-------------------------------------------------

        $result .= '1001';

        return $result;
    }
}

/**
 * Barcode_Code11 Class
 *
 * @since   2.0.3
 * @package BCCL
 */
class Barcode_Code11
{
    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @var     array
     */
    private static $encoding = array( '101011', '1101011', '1001011', '1100101', '1011011', '1101101', '1001101', '1010011', '1101001', '110101', '101101' );

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getDigit( $code )
    {
        if ( preg_match( '`[^0-9\-]`', $code ) ) return '';

        $result = '';

        $intercharacter = '0';

        //-------------------------------------------------
        // start
        //-------------------------------------------------

        $result = '1011001' . $intercharacter;

        //-------------------------------------------------
        // digits
        //-------------------------------------------------

        $len = strlen( $code );

        for ( $i = 0; $i < $len; $i++ )
        {
            $index = $code[ $i ] == '-' ? 10 : intval( $code[ $i ] );

            $result .= self::$encoding[ $index ] . $intercharacter;
        }

        //-------------------------------------------------
        // checksum
        //-------------------------------------------------

        $weightC = 0;

        $weightSumC = 0;

        $weightK = 1; // start at 1 because the right-most character is 'C' checksum

        $weightSumK = 0;

        for ( $i = $len - 1; $i >- 1; $i-- )
        {
            $weightC = $weightC == 10 ? 1 : $weightC + 1;
            $weightK = $weightK == 10 ? 1 : $weightK + 1;

            $index = $code[ $i ] == '-' ? 10 : intval( $code[ $i ] );

            $weightSumC += $weightC * $index;
            $weightSumK += $weightK * $index;
        }

        $c = $weightSumC % 11;

        $weightSumK += $c;

        $k = $weightSumK % 11;

        $result .= self::$encoding[ $c ] . $intercharacter;

        if ( $len >= 10 )
        {
            $result .= self::$encoding[ $k ] . $intercharacter;
        }

        //-------------------------------------------------
        // stop
        //-------------------------------------------------

        $result .= '1011001';

        return $result;
    }
}

/**
 * Barcode_Code39 Class
 *
 * @since   2.0.3
 * @package BCCL
 */
class Barcode_Code39
{
    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @var     array
     */
    private static $encoding = array( '101001101101', '110100101011', '101100101011', '110110010101', '101001101011', '110100110101', '101100110101', '101001011011', '110100101101', '101100101101', '110101001011', '101101001011', '110110100101', '101011001011', '110101100101', '101101100101', '101010011011', '110101001101', '101101001101', '101011001101', '110101010011', '101101010011', '110110101001', '101011010011', '110101101001', '101101101001', '101010110011', '110101011001', '101101011001', '101011011001', '110010101011', '100110101011', '110011010101', '100101101011', '110010110101', '100110110101', '100101011011', '110010101101', '100110101101', '100100100101', '100100101001', '100101001001', '101001001001', '100101101101' );

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getDigit( $code )
    {
        $table = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ-. $/+%*';

        $result = '';

        $intercharacter = '0';

        if ( strpos( $code, '*' ) !== false ) return '';

        //-------------------------------------------------
        // Add Start and Stop charactere : *
        //-------------------------------------------------

        $code = strtoupper( '*' . $code . '*' );

        $len = strlen( $code );

        for ( $i = 0; $i < $len; $i++ )
        {
            $index = strpos( $table, $code[ $i ] );

            if ( $index === false ) return '';

            if ( $i > 0 ) $result .= $intercharacter;

            $result .= self::$encoding[ $index ];
        }

        return $result;
    }
}

/**
 * Barcode_Code93 Class
 *
 * @since   2.0.3
 * @package BCCL
 */
class Barcode_Code93
{
    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @var     array
     */
    private static $encoding = array( '100010100', '101001000', '101000100', '101000010', '100101000', '100100100', '100100010', '101010000', '100010010', '100001010', '110101000', '110100100', '110100010', '110010100', '110010010', '110001010', '101101000', '101100100', '101100010', '100110100', '100011010', '101011000', '101001100', '101000110', '100101100', '100010110', '110110100', '110110010', '110101100', '110100110', '110010110', '110011010', '101101100', '101100110', '100110110', '100111010', '100101110', '111010100', '111010010', '111001010', '101101110', '101110110', '110101110', '100100110', '111011010', '111010110', '100110010', '101011110' );

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getDigit( $code, $crc )
    {
        $table = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ-. $/+%____*'; // _ => ( $ ), ( % ), ( / ) et ( + )

        $result = '';

        if ( strpos( $code, '*' ) !== false ) return '';

        $code = strtoupper( $code );

        //-------------------------------------------------
        // start : *
        //-------------------------------------------------

        $result .= self::$encoding[ 47 ];

        //-------------------------------------------------
        // digits
        //-------------------------------------------------

        $len = strlen( $code );

        for ( $i = 0; $i < $len; $i++ )
        {
            $c = $code[ $i ];

            $index = strpos( $table, $c );

            if ( ( $c == '_' ) || ( $index === false ) ) return '';

            $result .= self::$encoding[ $index ];
        }

        //-------------------------------------------------
        // checksum
        //-------------------------------------------------

        if ( $crc )
        {
            $weightC = 0;

            $weightSumC = 0;

            $weightK = 1; // start at 1 because the right-most character is 'C' checksum

            $weightSumK = 0;

            for ( $i = $len - 1; $i >- 1; $i-- )
            {
                $weightC = $weightC == 20 ? 1 : $weightC + 1;
                $weightK = $weightK == 15 ? 1 : $weightK + 1;

                $index = strpos( $table, $code[ $i ] );

                $weightSumC += $weightC * $index;
                $weightSumK += $weightK * $index;
            }

            $c = $weightSumC % 47;

            $weightSumK += $c;

            $k = $weightSumK % 47;

            $result .= self::$encoding[ $c ];
            $result .= self::$encoding[ $k ];
        }

        //-------------------------------------------------
        // stop : *
        //-------------------------------------------------

        $result .= self::$encoding[ 47 ];

        //-------------------------------------------------
        // Terminaison bar
        //-------------------------------------------------

        $result .= '1';

        return $result;
    }
}

/**
 * Barcode_Code128 Class
 *
 * @since   2.0.3
 * @package BCCL
 */
class Barcode_Code128
{
    /**
     * DEFAULT
     *
     * descriptive encoding array, helpful when debugging
     * Value Table A Table B Table C ASCII Code  Character   Pattern
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @var     array
     */
    private static $encoding = array(
        '11011001100', //  0    Space   Space   00      0032 or 0212    Space or O  11011001100
        '11001101100', //  1    !       !       01      0033    !   11001101100
        '11001100110', //  2    "       "       02      0034    "   11001100110
        '10010011000', //  3    #       #       03      0035    #   10010011000
        '10010001100', //  4    $       $       04      0036    $   10010001100
        '10001001100', //  5    %       %       05      0037    %   10001001100
        '10011001000', //  6    &       &       06      0038    &   10011001000
        '10011000100', //  7    '       '       07      0039    '   10011000100
        '10001100100', //  8    (       (       08      0040    (   10001100100
        '11001001000', //  9    )       )       09      0041    )   11001001000
        '11001000100', //  10   *       *       10      0042    *   11001000100
        '11000100100', //  11   +       +       11      0043    +   11000100100
        '10110011100', //  12   ,       ,       12      0044    ,   10110011100
        '10011011100', //  13   -       -       13      0045    -   10011011100
        '10011001110', //  14   .       .       14      0046    .   10011001110
        '10111001100', //  15   /       /       15      0047    /   10111001100
        '10011101100', //  16   0       0       16      0048    0   10011101100
        '10011100110', //  17   1       1       17      0049    1   10011100110
        '11001110010', //  18   2       2       18      0050    2   11001110010
        '11001011100', //  19   3       3       19      0051    3   11001011100
        '11001001110', //  20   4       4       20      0052    4   11001001110
        '11011100100', //  21   5       5       21      0053    5   11011100100
        '11001110100', //  22   6       6       22      0054    6   11001110100
        '11101101110', //  23   7       7       23      0055    7   11101101110
        '11101001100', //  24   8       8       24      0056    8   11101001100
        '11100101100', //  25   9       9       25      0057    9   11100101100
        '11100100110', //  26   :       :       26      0058    :   11100100110
        '11101100100', //  27   ;       ;       27      0059    ;   11101100100
        '11100110100', //  28   <       <       28      0060    <   11100110100
        '11100110010', //  29   =       =       29      0061    =   11100110010
        '11011011000', //  30   >       >       30      0062    >   11011011000
        '11011000110', //  31   ?       ?       31      0063    ?   11011000110
        '11000110110', //  32   @       @       32      0064    @   11000110110
        '10100011000', //  33   A       A       33      0065    A   10100011000
        '10001011000', //  34   B       B       34      0066    B   10001011000
        '10001000110', //  35   C       C       35      0067    C   10001000110
        '10110001000', //  36   D       D       36      0068    D   10110001000
        '10001101000', //  37   E       E       37      0069    E   10001101000
        '10001100010', //  38   F       F       38      0070    F   10001100010
        '11010001000', //  39   G       G       39      0071    G   11010001000
        '11000101000', //  40   H       H       40      0072    H   11000101000
        '11000100010', //  41   I       I       41      0073    I   11000100010
        '10110111000', //  42   J       J       42      0074    J   10110111000
        '10110001110', //  43   K       K       43      0075    K   10110001110
        '10001101110', //  44   L       L       44      0076    L   10001101110
        '10111011000', //  45   M       M       45      0077    M   10111011000
        '10111000110', //  46   N       N       46      0078    N   10111000110
        '10001110110', //  47   O       O       47      0079    O   10001110110
        '11101110110', //  48   P       P       48      0080    P   11101110110
        '11010001110', //  49   Q       Q       49      0081    Q   11010001110
        '11000101110', //  50   R       R       50      0082    R   11000101110
        '11011101000', //  51   S       S       51      0083    S   11011101000
        '11011100010', //  52   T       T       52      0084    T   11011100010
        '11011101110', //  53   U       U       53      0085    U   11011101110
        '11101011000', //  54   V       V       54      0086    V   11101011000
        '11101000110', //  55   W       W       55      0087    W   11101000110
        '11100010110', //  56   X       X       56      0088    X   11100010110
        '11101101000', //  57   Y       Y       57      0089    Y   11101101000
        '11101100010', //  58   Z       Z       58      0090    Z   11101100010
        '11100011010', //  59   [       [       59      0091    [   11100011010
        '11101111010', //  60   \       \       60      0092    \   11101111010
        '11001000010', //  61   ]       ]       61      0093    ]   11001000010
        '11110001010', //  62   ^       ^       62      0094    ^   11110001010
        '10100110000', //  63   _       _       63      0095    _   10100110000
        '10100001100', //  64   nul     `       64      0096    `   10100001100
        '10010110000', //  65   soh     a       65      0097    a   10010110000
        '10010000110', //  66   stx     b       66      0098    b   10010000110
        '10000101100', //  67   etx     c       67      0099    c   10000101100
        '10000100110', //  68   eot     d       68      0100    d   10000100110
        '10110010000', //  69   eno     e       69      0101    e   10110010000
        '10110000100', //  70   ack     f       70      0102    f   10110000100
        '10011010000', //  71   bel     g       71      0103    g   10011010000
        '10011000010', //  72   bs      h       72      0104    h   10011000010
        '10000110100', //  73   ht      i       73      0105    i   10000110100
        '10000110010', //  74   lf      j       74      0106    j   10000110010
        '11000010010', //  75   vt      k       75      0107    k   11000010010
        '11001010000', //  76   ff      l       76      0108    l   11001010000
        '11110111010', //  77   cr      m       77      0109    m   11110111010
        '11000010100', //  78   s0      n       78      0110    n   11000010100
        '10001111010', //  79   s1      o       79      0111    o   10001111010
        '10100111100', //  80   dle     p       80      0112    p   10100111100
        '10010111100', //  81   dc1     q       81      0113    q   10010111100
        '10010011110', //  82   dc2     r       82      0114    r   10010011110
        '10111100100', //  83   dc3     s       83      0115    s   10111100100
        '10011110100', //  84   dc4     t       84      0116    t   10011110100
        '10011110010', //  85   nak     u       85      0117    u   10011110010
        '11110100100', //  86   syn     v       86      0118    v   11110100100
        '11110010100', //  87   etb     w       87      0119    w   11110010100
        '11110010010', //  88   can     x       88      0120    x   11110010010
        '11011011110', //  89   em      y       89      0121    y   11011011110
        '11011110110', //  90   sub     z       90      0122    z   11011110110
        '11110110110', //  91   esc     {       91      0123    {   11110110110
        '10101111000', //  92   fs      |       92      0124    |   10101111000
        '10100011110', //  93   gs      }       93      0125    }   10100011110
        '10001011110', //  94   rs      ~       94      0126    ~   10001011110
        '10111101000', //  95   us      del     95      0200    E   10111101000
        '10111100010', //  96   Fnc 3   Fnc 3   96      0201    E   10111100010
        '11110101000', //  97   Fnc 2   Fnc2    97      0202    E   11110101000
        '11110100010', //  98   Shift   Shift   98      0203    E   11110100010
        '10111011110', //  99   Code C  Code C  99      0204    I   10111011110
        '10111101110', //  100  Code B  Fnc 4   Code B  0205    I   10111101110
        '11101011110', //  101  Fnc 4   Code A  Code A  0206    I   11101011110
        '11110101110', //  102  Fnc 1   Fnc 1   Fnc 1   0207    I   11110101110
        '11010000100', //  103  Start A Start A Start A 0208    D   11010000100
        '11010010000', //  104  Start B Start B Start B 0209    N   11010010000
        '11010011100', //  105  Start C Start C Start C 0210    O   11010011100
        '11000111010', //  106  Stop    Stop    Stop    0211    O   11000111010
        '11'           //  107  Termination bar
    );

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getDigit( $code )
    {
        $tableB = " !\"#$%&'()*+, -./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[ \ ]^_`abcdefghijklmnopqrstuvwxyz{|}~";

        $result = '';

        $sum = 0;

        $isum = 0;

        $i = 0;

        $j = 0;

        $value = 0;

        //-------------------------------------------------
        // check each characters
        //-------------------------------------------------

        $len = strlen( $code );

        // we allow now extended ASCII so no need to check against table B

        // for ( $i = 0; $i < $len; $i++ )
        // {
        //     if ( strpos( $tableB, $code[ $i ] ) === false ) return '';
        // }

        //-------------------------------------------------
        // check firsts characters
        // start with C table only if enought numeric
        //-------------------------------------------------

        $tableCActivated = $len> 1;

        $c = '';

        for ( $i = 0; $i < 3 && $i < $len; $i++ )
        {
            $tableCActivated &= preg_match( '`[0-9]`', $code[ $i ] );
        }

        $sum = $tableCActivated ? 105 : 104;

        //-------------------------------------------------
        // start : [ 105 ] : C table or [ 104 ] : B table
        //-------------------------------------------------

        $result = self::$encoding[ $sum ];

        $i = 0;

        while ( $i < $len )
        {
            if ( ! $tableCActivated )
            {
                $j = 0;

                //-------------------------------------------------
                // check next character to activate C table
                // if interresting
                //-------------------------------------------------

                while ( ( $i + $j < $len ) && preg_match( '`[0-9]`', $code[ $i + $j ] ) ) $j++;

                //-------------------------------------------------
                // 6 min everywhere or 4 mini at the end
                //-------------------------------------------------

                $tableCActivated = ( $j > 5 ) || ( ( $i + $j - 1 == $len ) && ( $j > 3 ) );

                if ( $tableCActivated )
                {
                    //-------------------------------------------------
                    // C table
                    //-------------------------------------------------

                    $result .= self::$encoding[ 99 ];

                    $sum += ++$isum * 99;
                }

                //-------------------------------------------------
                // 2 min for table C so need table B
                //-------------------------------------------------
            }
            else if ( ( $i == $len - 1 ) || ( preg_match( '`[^0-9]`', $code[ $i ] ) ) || ( preg_match( '`[^0-9]`', $code[ $i + 1 ] ) ) )
            {
                //-------------------------------------------------
                // todo : verifier le JS : len - 1!
                //-------------------------------------------------

                $tableCActivated = false;

                //-------------------------------------------------
                // B table
                //-------------------------------------------------

                $result .= self::$encoding[ 100 ];

                $sum += ++$isum * 100;
            }

            if ( $tableCActivated )
            {
                //-------------------------------------------------
                // Add two characters ( numeric )
                //-------------------------------------------------

                $value = intval( substr( $code, $i, 2 ) );

                $i += 2;
            }
            else
            {
                //-------------------------------------------------
                // take care of extended characters
                // (ASCII above 127)
                //-------------------------------------------------

                if ( ord( $code[ $i ] ) > 126 )
                {
                    $result .= self::$encoding[ 100 ];

                    $sum += ++$isum * 100;

                    //-------------------------------------------------
                    // Add one character
                    //-------------------------------------------------

                    $value = strpos( $tableB, chr( ord( $code[ $i ] ) - 128 ) );
                }
                else
                {
                    //-------------------------------------------------
                    // Add one character
                    //-------------------------------------------------

                    $value = strpos( $tableB, $code[ $i ] );
                }

                $i++;
            }

            $result .= self::$encoding[ $value ];

            $sum += ++$isum * $value;
        }

        //-------------------------------------------------
        // Add CRC
        //-------------------------------------------------

        $result .= self::$encoding[ $sum % 103 ];

        //-------------------------------------------------
        // stop
        //-------------------------------------------------

        $result .= self::$encoding[ 106 ];

        //-------------------------------------------------
        // Termination bar
        //-------------------------------------------------

        $result .= '11';

        return $result;
    }
}

/**
 * Barcode_Codabar Class
 *
 * @since   2.0.3
 * @package BCCL
 */
class Barcode_Codabar
{
    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @var     array
     */
    private static $encoding = array( '101010011', '101011001', '101001011', '110010101', '101101001', '110101001', '100101011', '100101101', '100110101', '110100101', '101001101', '101100101', '1101011011', '1101101011', '1101101101', '1011011011', '1011001001', '1010010011', '1001001011', '1010011001' );

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getDigit( $code )
    {
        $table = '0123456789-$:/.+';

        $result = '';

        $intercharacter = '0';

        //-------------------------------------------------
        // add start : A -> D : arbitrary choose A
        //-------------------------------------------------

        $result .= self::$encoding[ 16 ] . $intercharacter;

        $len = strlen( $code );

        for ( $i = 0; $i < $len; $i++ )
        {
            $index = strpos( $table, $code[ $i ] );

            if ( $index === false ) return '';

            $result .= self::$encoding[ $index ] . $intercharacter;
        }

        //-------------------------------------------------
        // add stop : A -> D : arbitrary choose A
        //-------------------------------------------------

        $result .= self::$encoding[ 16 ];

        return $result;
    }
}

/**
 * Barcode_DataMatrix Class
 *
 * @since   2.0.3
 * @package BCCL
 */
class Barcode_DataMatrix
{
    /**
     * 24 squares et 6 rectangular
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @var     array
     */
    private static $lengthRows = array( 10, 12, 14, 16, 18, 20, 22, 24, 26, 32, 36, 40, 44, 48, 52, 64, 72, 80,  88, 96, 104, 120, 132, 144, 8, 8, 12, 12, 16, 16 );

    /**
     * Number of columns for the entire datamatrix
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @var     array
     */
    private static $lengthCols = array( 10, 12, 14, 16, 18, 20, 22, 24, 26, 32, 36, 40, 44, 48, 52, 64, 72, 80, 88, 96, 104, 120, 132, 144, 18, 32, 26, 36, 36, 48 );

    /**
     * Number of data codewords for the datamatrix
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @var     array
     */
    private static $dataCWCount = array( 3, 5, 8, 12, 18, 22, 30, 36, 44, 62, 86, 114, 144, 174, 204, 280, 368, 456, 576, 696, 816, 1050, 1304, 1558, 5, 10, 16, 22, 32, 49 );

    /**
     * Number of Reed-Solomon codewords for the datamatrix
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @var     array
     */
    private static $solomonCWCount = array( 5, 7, 10, 12, 14, 18, 20, 24, 28, 36, 42, 48, 56, 68, 84, 112, 144, 192, 224, 272, 336, 408, 496, 620, 7, 11, 14, 18, 24, 28 );

    /**
     * Number of rows per region
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @var     array
     */
    private static $dataRegionRows = array( 8, 10, 12, 14, 16, 18, 20, 22, 24, 14, 16, 18, 20, 22, 24, 14, 16, 18, 20, 22, 24, 18, 20, 22, 6,  6, 10, 10, 14, 14 );

    /**
     * Number of columns per region
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @var     array
     */
    private static $dataRegionCols = array( 8, 10, 12, 14, 16, 18, 20, 22, 24, 14, 16, 18, 20, 22, 24, 14, 16, 18, 20, 22, 24, 18, 20, 22, 16, 14, 24, 16, 16, 22 );

    /**
     * Number of regions per row
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @var     array
     */
    private static $regionRows = array( 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 4, 4, 4, 4, 4, 4, 6, 6, 6, 1, 1, 1, 1, 1, 1 );

    /**
     * Number of regions per column
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @var     array
     */
    private static $regionCols = array( 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 4, 4, 4, 4, 4, 4, 6, 6, 6, 1, 2, 1, 2, 2, 2 );

    /**
     * Number of blocks
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @var     array
     */
    private static $interleavedBlocks = array( 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 4, 4, 4, 4, 6, 6, 8, 8, 1, 1, 1, 1, 1, 1 );

    /**
     * Table of log for the Galois field
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @var     array
     */
    private static $logTab = array( -255, 255, 1, 240, 2, 225, 241, 53, 3, 38, 226, 133, 242, 43, 54, 210, 4, 195, 39, 114, 227, 106, 134, 28, 243, 140, 44, 23, 55, 118, 211, 234, 5, 219, 196, 96, 40, 222, 115, 103, 228, 78, 107, 125, 135, 8, 29, 162, 244, 186, 141, 180, 45, 99, 24, 49, 56, 13, 119, 153, 212, 199, 235, 91, 6, 76, 220, 217, 197, 11, 97, 184, 41, 36, 223, 253, 116, 138, 104, 193, 229, 86, 79, 171, 108, 165, 126, 145, 136, 34, 9, 74, 30, 32, 163, 84, 245, 173, 187, 204, 142, 81, 181, 190, 46, 88, 100, 159, 25, 231, 50, 207, 57, 147, 14, 67, 120, 128, 154, 248, 213, 167, 200, 63, 236, 110, 92, 176, 7, 161, 77, 124, 221, 102, 218, 95, 198, 90, 12, 152, 98, 48, 185, 179, 42, 209, 37, 132, 224, 52, 254, 239, 117, 233, 139, 22, 105, 27, 194, 113, 230, 206, 87, 158, 80, 189, 172, 203, 109, 175, 166, 62, 127, 247, 146, 66, 137, 192, 35, 252, 10, 183, 75, 216, 31, 83, 33, 73, 164, 144, 85, 170, 246, 65, 174, 61, 188, 202, 205, 157, 143, 169, 82, 72, 182, 215, 191, 251, 47, 178, 89, 151, 101, 94, 160, 123, 26, 112, 232, 21, 51, 238, 208, 131, 58, 69, 148, 18, 15, 16, 68, 17, 121, 149, 129, 19, 155, 59, 249, 70, 214, 250, 168, 71, 201, 156, 64, 60, 237, 130, 111, 20, 93, 122, 177, 150 );

    /**
     * Table of aLog for the Galois field
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @var     array
     */
    private static $aLogTab = array( 1, 2, 4, 8, 16, 32, 64, 128, 45, 90, 180, 69, 138, 57, 114, 228, 229, 231, 227, 235, 251, 219, 155, 27, 54, 108, 216, 157, 23, 46, 92, 184, 93, 186, 89, 178, 73, 146, 9, 18, 36, 72, 144, 13, 26, 52, 104, 208, 141, 55, 110, 220, 149, 7, 14, 28, 56, 112, 224, 237, 247, 195, 171, 123, 246, 193, 175, 115, 230, 225, 239, 243, 203, 187, 91, 182, 65, 130, 41, 82, 164, 101, 202, 185, 95, 190, 81, 162, 105, 210, 137, 63, 126, 252, 213, 135, 35, 70, 140, 53, 106, 212, 133, 39, 78, 156, 21, 42, 84, 168, 125, 250, 217, 159, 19, 38, 76, 152, 29, 58, 116, 232, 253, 215, 131, 43, 86, 172, 117, 234, 249, 223, 147, 11, 22, 44, 88, 176, 77, 154, 25, 50, 100, 200, 189, 87, 174, 113, 226, 233, 255, 211, 139, 59, 118, 236, 245, 199, 163, 107, 214, 129, 47, 94, 188, 85, 170, 121, 242, 201, 191, 83, 166, 97, 194, 169, 127, 254, 209, 143, 51, 102, 204, 181, 71, 142, 49, 98, 196, 165, 103, 206, 177, 79, 158, 17, 34, 68, 136, 61, 122, 244, 197, 167, 99, 198, 161, 111, 222, 145, 15, 30, 60, 120, 240, 205, 183, 67, 134, 33, 66, 132, 37, 74, 148, 5, 10, 20, 40, 80, 160, 109, 218, 153, 31, 62, 124, 248, 221, 151, 3, 6, 12, 24, 48, 96, 192, 173, 119, 238, 241, 207, 179, 75, 150, 1 );

    /**
     * Multiplication in Galois field gf( 2^8 )
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function champGaloisMult( $a, $b )
    {
        if ( ! $a || ! $b ) return 0;

        return self::$aLogTab[ ( self::$logTab[ $a ] + self::$logTab[ $b ] ) % 255 ];
    }

    /**
     * The operation a * 2^b in Galois field gf( 2^8 )
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function champGaloisDoub( $a, $b )
    {
        if ( ! $a ) return 0;

        if ( ! $b ) return $a;

        return self::$aLogTab[ ( self::$logTab[ $a ] + $b ) % 255 ];
    }

    /**
     * Sum in Galois field gf( 2^8 )
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function champGaloisSum( $a, $b )
    {
        return $a ^ $b;
    }

    /**
     * Choose the good index for tables
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function selectIndex( $dataCodeWordsCount, $rectangular )
    {
        if ( ( $dataCodeWordsCount < 1 || $dataCodeWordsCount > 1558 ) && ! $rectangular ) return ( -1 );

        if ( ( $dataCodeWordsCount < 1 || $dataCodeWordsCount > 49 ) && $rectangular )  return ( -1 );

        $n = $rectangular ? 24 : 0;

        while ( self::$dataCWCount[ $n ] < $dataCodeWordsCount ) $n++;

        return $n;
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function encodeDataCodeWordsASCII( $text )
    {
        $dataCodeWords = array();

        $n = 0;

        $len = strlen( $text );

        for ( $i = 0; $i < $len; $i++ )
        {
            $c = ord( $text[ $i ] );

            if ( $c > 127 )
            {
                $dataCodeWords[ $n ] = 235;

                $c -= 127;

                $n++;
            }
            else if ( ( $c >= 48 && $c <= 57 ) && ( $i + 1 < $len ) && ( preg_match( '`[0-9]`', $text[ $i + 1 ] ) ) )
            {
                $c = ( ( $c - 48 ) * 10 ) + intval( $text[ $i+1 ] );

                $c += 130;

                $i++;
            }
            else
            {
                $c++;
            }

            $dataCodeWords[ $n ] = $c;

            $n++;
        }

        return $dataCodeWords;
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function addPadCW( &$tab, $from, $to )
    {
        if ( $from >= $to ) return ;

        $tab[ $from ] = 129;

        for ( $i = $from + 1; $i < $to; $i++ )
        {
            $r = ( ( 149 * ( $i + 1 ) ) % 253 ) + 1;

            $tab[ $i ] = ( 129 + $r ) % 254;
        }
    }

    /**
     * Calculate the reed solomon factors
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function calculSolFactorTable( $solomonCWCount )
    {
        $g = array_fill( 0, $solomonCWCount + 1, 1 );

        for ( $i = 1; $i <= $solomonCWCount; $i++ )
        {
            for ( $j = $i - 1; $j >= 0; $j-- )
            {
                $g[ $j ] = self::champGaloisDoub( $g[ $j ], $i );

                if ( $j > 0 ) $g[ $j ] = self::champGaloisSum( $g[ $j ], $g[ $j - 1 ] );
            }
        }

        return $g;
    }

    /**
     * Add the Reed Solomon codewords
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function addReedSolomonCW( $nSolomonCW, $coeffTab, $nDataCW, &$dataTab, $blocks )
    {
        $errorBlocks = $nSolomonCW / $blocks;

        $correctionCW = array();

        for ( $k = 0; $k < $blocks; $k++ )
        {
            for ( $i = 0; $i < $errorBlocks; $i++ )
            {
                $correctionCW[ $i ] = 0;
            }

            for ( $i = $k; $i < $nDataCW; $i += $blocks )
            {
                $temp = self::champGaloisSum( $dataTab[ $i ], $correctionCW[ $errorBlocks - 1 ] );

                for ( $j = $errorBlocks - 1; $j >= 0; $j-- )
                {
                    if ( ! $temp )
                    {
                        $correctionCW[ $j ] = 0;
                    }
                    else
                    {
                        $correctionCW[ $j ] = self::champGaloisMult( $temp, $coeffTab[ $j ] );
                    }

                    if ( $j > 0 )
                    {
                        $correctionCW[ $j ] = self::champGaloisSum( $correctionCW[ $j - 1 ], $correctionCW[ $j ] );
                    }
                }
            }

            //-------------------------------------------------
            // Renversement des blocs calcules
            //-------------------------------------------------

            $j = $nDataCW + $k;

            for ( $i = $errorBlocks - 1; $i >= 0; $i-- )
            {
                $dataTab[ $j ] = $correctionCW[ $i ];

                $j = $j + $blocks;
            }
        }

        return $dataTab;
    }

    /**
     * Transform integer to tab of bits
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function getBits( $entier )
    {
        $bits = array();

        for ( $i = 0; $i < 8; $i++ )
        {
            $bits[ $i ] = $entier & ( 128 >> $i ) ? 1 : 0;
        }

        return $bits;
    }

    /**
     * Place codewords into the matrix
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function next( $etape, $totalRows, $totalCols, $codeWordsBits, &$datamatrix, &$assigned )
    {
        //-------------------------------------------------
        // Place of the 8st bit from the first
        // character to [ 4 ][ 0 ]
        //-------------------------------------------------

        $chr = 0;

        $row = 4;

        $col = 0;

        do
        {
            //-------------------------------------------------
            // Check for a special case of corner
            //-------------------------------------------------

            if ( ( $row == $totalRows ) && ( $col == 0 ) )
            {
                self::patternShapeSpecial1( $datamatrix, $assigned, $codeWordsBits[ $chr ], $totalRows, $totalCols );

                $chr++;
            }
            else if ( ( $etape < 3 ) && ( $row == $totalRows - 2 ) && ( $col == 0 ) && ( $totalCols % 4 != 0 ) )
            {
                self::patternShapeSpecial2( $datamatrix, $assigned, $codeWordsBits[ $chr ], $totalRows, $totalCols );

                $chr++;
            }
            else if ( ( $row == $totalRows - 2 ) && ( $col == 0 ) && ( $totalCols % 8 == 4 ) )
            {
                self::patternShapeSpecial3( $datamatrix, $assigned, $codeWordsBits[ $chr ], $totalRows, $totalCols );

                $chr++;
            }
            else if ( ( $row == $totalRows + 4 ) && ( $col == 2 ) && ( $totalCols % 8 == 0 ) )
            {
                self::patternShapeSpecial4( $datamatrix, $assigned, $codeWordsBits[ $chr ], $totalRows, $totalCols );

                $chr++;
            }

            //-------------------------------------------------
            // Go up and right in the datamatrix
            //-------------------------------------------------

            do
            {
                if ( ( $row < $totalRows ) && ( $col >= 0 ) && ( ! isset( $assigned[ $row ][ $col ] ) || $assigned[ $row ][ $col ] != 1 ) )
                {
                    self::patternShapeStandard( $datamatrix, $assigned, $codeWordsBits[ $chr ], $row, $col, $totalRows, $totalCols );

                    $chr++;
                }

                $row -= 2;
                $col += 2;
            }
            while ( ( $row >= 0 ) && ( $col < $totalCols ) );

            $row += 1;
            $col += 3;

            //-------------------------------------------------
            // Go down and left in the datamatrix
            //-------------------------------------------------

            do
            {
                if ( ( $row >= 0 ) && ( $col < $totalCols ) && ( !isset( $assigned[ $row ][ $col ] ) || $assigned[ $row ][ $col ] != 1 ) )
                {
                    self::patternShapeStandard( $datamatrix, $assigned, $codeWordsBits[ $chr ], $row, $col, $totalRows, $totalCols );

                    $chr++;
                }

                $row += 2;
                $col -= 2;
            }
            while ( ( $row < $totalRows ) && ( $col >= 0 ) );

            $row += 3;
            $col += 1;
        }
        while ( ( $row < $totalRows ) || ( $col < $totalCols ) );
    }

    /**
     * Place bits in the matrix ( standard or special case )
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function patternShapeStandard( &$datamatrix, &$assigned, $bits, $row, $col, $totalRows, $totalCols )
    {
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 0 ], $row - 2, $col - 2, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 1 ], $row - 2, $col - 1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 2 ], $row - 1, $col - 2, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 3 ], $row - 1, $col - 1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 4 ], $row - 1, $col, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 5 ], $row, $col - 2, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 6 ], $row, $col - 1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 7 ], $row, $col, $totalRows, $totalCols );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function patternShapeSpecial1( &$datamatrix, &$assigned, $bits, $totalRows, $totalCols )
    {
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 0 ], $totalRows - 1, 0, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 1 ], $totalRows - 1, 1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 2 ], $totalRows - 1, 2, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 3 ], 0, $totalCols - 2, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 4 ], 0, $totalCols - 1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 5 ], 1, $totalCols - 1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 6 ], 2, $totalCols - 1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 7 ], 3, $totalCols - 1, $totalRows, $totalCols );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function patternShapeSpecial2( &$datamatrix, &$assigned, $bits, $totalRows, $totalCols )
    {
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 0 ], $totalRows - 3, 0, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 1 ], $totalRows - 2, 0, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 2 ], $totalRows - 1, 0, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 3 ], 0, $totalCols - 4, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 4 ], 0, $totalCols - 3, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 5 ], 0, $totalCols - 2, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 6 ], 0, $totalCols - 1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 7 ], 1, $totalCols - 1, $totalRows, $totalCols );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function patternShapeSpecial3( &$datamatrix, &$assigned, $bits, $totalRows, $totalCols )
    {
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 0 ], $totalRows - 3, 0, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 1 ], $totalRows - 2, 0, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 2 ], $totalRows - 1, 0, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 3 ], 0, $totalCols - 2, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 4 ], 0, $totalCols - 1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 5 ], 1, $totalCols - 1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 6 ], 2, $totalCols - 1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 7 ], 3, $totalCols - 1, $totalRows, $totalCols );
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function patternShapeSpecial4( &$datamatrix, &$assigned, $bits, $totalRows, $totalCols )
    {
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 0 ], $totalRows - 1, 0, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 1 ], $totalRows - 1, $totalCols - 1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 2 ], 0, $totalCols - 3, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 3 ], 0, $totalCols - 2, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 4 ], 0, $totalCols - 1, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 5 ], 1, $totalCols - 3, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 6 ], 1, $totalCols - 2, $totalRows, $totalCols );
        self::placeBitInDatamatrix( $datamatrix, $assigned, $bits[ 7 ], 1, $totalCols - 1, $totalRows, $totalCols );
    }

    /**
     * Put a bit into the matrix
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function placeBitInDatamatrix( &$datamatrix, &$assigned, $bit, $row, $col, $totalRows, $totalCols )
    {
        if ( $row < 0 )
        {
            $row += $totalRows;

            $col += 4 - ( ( $totalRows + 4 ) % 8 );
        }

        if ( $col < 0 )
        {
            $col += $totalCols;

            $row += 4 - ( ( $totalCols + 4 ) % 8 );
        }

        if ( ! isset( $assigned[ $row ][ $col ] ) || $assigned[ $row ][ $col ] != 1 )
        {
            $datamatrix[ $row ][ $col ] = $bit;

            $assigned[ $row ][ $col ] = 1;
        }
    }

    /**
     * Add the finder pattern
     *
     * @since   2.0.3
     * @access  private
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    private static function addFinderPattern( $datamatrix, $rowsRegion, $colsRegion, $rowsRegionCW, $colsRegionCW )
    {
        $totalRowsCW = ( $rowsRegionCW + 2 ) * $rowsRegion;

        $totalColsCW = ( $colsRegionCW + 2 ) * $colsRegion;

        $datamatrixTemp = array();

        $datamatrixTemp[ 0 ] = array_fill( 0, $totalColsCW + 2, 0 );

        for ( $i = 0; $i < $totalRowsCW; $i++ )
        {
            $datamatrixTemp[ $i + 1 ] = array();

            $datamatrixTemp[ $i + 1 ][ 0 ] = 0;

            $datamatrixTemp[ $i + 1 ][ $totalColsCW + 1 ] = 0;

            for ( $j = 0; $j < $totalColsCW; $j++ )
            {
                if ( $i % ( $rowsRegionCW + 2 ) == 0 )
                {
                    if ( $j % 2 == 0 )
                    {
                        $datamatrixTemp[ $i + 1 ][ $j + 1 ] = 1;
                    }
                    else
                    {
                        $datamatrixTemp[ $i + 1 ][ $j + 1 ] = 0;
                    }
                }
                else if ( $i % ( $rowsRegionCW + 2 ) == $rowsRegionCW + 1 )
                {
                    $datamatrixTemp[ $i + 1 ][ $j + 1 ] = 1;
                }
                else if ( $j % ( $colsRegionCW + 2 ) == $colsRegionCW + 1 )
                {
                    if ( $i % 2 == 0 )
                    {
                        $datamatrixTemp[ $i + 1 ][ $j + 1 ] = 0;
                    }
                    else
                    {
                        $datamatrixTemp[ $i + 1 ][ $j + 1 ] = 1;
                    }
                }
                else if ( $j % ( $colsRegionCW + 2 ) == 0 )
                {
                    $datamatrixTemp[ $i + 1 ][ $j + 1 ] = 1;
                }
                else
                {
                    $datamatrixTemp[ $i + 1 ][ $j + 1 ] = 0;

                    $datamatrixTemp[ $i + 1 ][ $j + 1 ] = $datamatrix[ $i - 1 - ( 2 * ( floor( $i / ( $rowsRegionCW + 2 ) ) ) ) ][ $j - 1 - ( 2 * ( floor( $j / ( $colsRegionCW + 2 ) ) ) ) ]; // todo : parseInt => ?
                }
            }
        }

        $datamatrixTemp[ $totalRowsCW + 1 ] = array();

        for ( $j = 0; $j < $totalColsCW + 2; $j++ )
        {
            $datamatrixTemp[ $totalRowsCW + 1 ][ $j ] = 0;
        }

        return $datamatrixTemp;
    }

    /**
     * DEFAULT
     *
     * @since   2.0.3
     * @access  public
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getDigit( $text, $rectangular )
    {
        //-------------------------------------------------
        // Code the text in the ASCII mode
        //-------------------------------------------------

        $dataCodeWords = self::encodeDataCodeWordsASCII( $text );

        $dataCWCount = count( $dataCodeWords );

        //-------------------------------------------------
        // Select the index for the data tables
        //-------------------------------------------------

        $index = self::selectIndex( $dataCWCount, $rectangular );

        //-------------------------------------------------
        // Number of data CW
        //-------------------------------------------------

        $totalDataCWCount = self::$dataCWCount[ $index ];

        //-------------------------------------------------
        // Number of Reed Solomon CW
        //-------------------------------------------------

        $solomonCWCount = self::$solomonCWCount[ $index ];

        //-------------------------------------------------
        // Number of CW
        //-------------------------------------------------

        $totalCWCount = $totalDataCWCount + $solomonCWCount;

        //-------------------------------------------------
        // Size of symbol
        //-------------------------------------------------

        $rowsTotal = self::$lengthRows[ $index ];

        $colsTotal = self::$lengthCols[ $index ];

        //-------------------------------------------------
        // Number of region
        //-------------------------------------------------

        $rowsRegion = self::$regionRows[ $index ];

        $colsRegion = self::$regionCols[ $index ];

        $rowsRegionCW = self::$dataRegionRows[ $index ];

        $colsRegionCW = self::$dataRegionCols[ $index ];

        //-------------------------------------------------
        // Size of matrice data
        //-------------------------------------------------

        $rowsLengthMatrice = $rowsTotal - 2 * $rowsRegion;

        $colsLengthMatrice = $colsTotal - 2 * $colsRegion;

        //-------------------------------------------------
        // Number of Reed Solomon blocks
        //-------------------------------------------------

        $blocks = self::$interleavedBlocks[ $index ];

        $errorBlocks = $solomonCWCount / $blocks;

        //-------------------------------------------------
        // Add codewords pads
        //-------------------------------------------------

        self::addPadCW( $dataCodeWords, $dataCWCount, $totalDataCWCount );

        //-------------------------------------------------
        // Calculate correction coefficients
        //-------------------------------------------------

        $g = self::calculSolFactorTable( $errorBlocks );

        //-------------------------------------------------
        // Add Reed Solomon codewords
        //-------------------------------------------------

        self::addReedSolomonCW( $solomonCWCount, $g, $totalDataCWCount, $dataCodeWords, $blocks );

        //-------------------------------------------------
        // Calculte bits from codewords
        //-------------------------------------------------

        $codeWordsBits = array();

        for ( $i = 0; $i < $totalCWCount; $i++ )
        {
            $codeWordsBits[ $i ] = self::getBits( $dataCodeWords[ $i ] );
        }

        $datamatrix = array_fill( 0, $colsLengthMatrice, array() );

        $assigned = array_fill( 0, $colsLengthMatrice, array() );

        //-------------------------------------------------
        // Add the bottom-right corner if needed
        //-------------------------------------------------

        if ( ( ( $rowsLengthMatrice * $colsLengthMatrice ) % 8 ) == 4 )
        {
            $datamatrix[ $rowsLengthMatrice - 2 ][ $colsLengthMatrice - 2 ] = 1;
            $datamatrix[ $rowsLengthMatrice - 1 ][ $colsLengthMatrice - 1 ] = 1;
            $datamatrix[ $rowsLengthMatrice - 1 ][ $colsLengthMatrice - 2 ] = 0;
            $datamatrix[ $rowsLengthMatrice - 2 ][ $colsLengthMatrice - 1 ] = 0;

            $assigned[ $rowsLengthMatrice - 2 ][ $colsLengthMatrice - 2 ] = 1;
            $assigned[ $rowsLengthMatrice - 1 ][ $colsLengthMatrice - 1 ] = 1;
            $assigned[ $rowsLengthMatrice - 1 ][ $colsLengthMatrice - 2 ] = 1;
            $assigned[ $rowsLengthMatrice - 2 ][ $colsLengthMatrice - 1 ] = 1;
        }

        //-------------------------------------------------
        // Put the codewords into the matrix
        //-------------------------------------------------

        self::next( 0, $rowsLengthMatrice, $colsLengthMatrice, $codeWordsBits, $datamatrix, $assigned );

        //-------------------------------------------------
        // Add the finder pattern
        //-------------------------------------------------

        $datamatrix = self::addFinderPattern( $datamatrix, $rowsRegion, $colsRegion, $rowsRegionCW, $colsRegionCW );

        return $datamatrix;
    }

    /**
     * DEFAULT
     *
     * @since   2.0.4
     * @access  public
     *
     * @static
     *
     * @param   integer/string/array $DEFAULT DEFAULT
     *
     * @return  integer/string/array $DEFAULT DEFAULT
     */
    public static function getLenghtColumn( $text )
    {
        $dataCodeWords = self::encodeDataCodeWordsASCII( $text );

        $dataCWCount = count( $dataCodeWords );

        $index = self::selectIndex( $dataCWCount, false );

        return self::$lengthCols[ $index ];
    }
}

/**
 * Barcode_QuickResponseCode Class
 *
 * @since   1.2.0
 * @package BCCL
 */
class Barcode_QuickResponseCode
{
    /**
     * Error correction level low.
     *
     * 7% of codewords can be restored.
     *
     * @since  2.0.17
     * @var    integer
     */
    const ECC_L = 1;

    /**
     * Error correction level medium.
     *
     * 15% of codewords can be restored.
     *
     * @since  2.0.17
     * @var    integer
     */
    const ECC_M = 0;

    /**
     * Error correction level quartile.
     *
     * 25% of codewords can be restored.
     *
     * @since  2.0.17
     * @var    integer
     */
    const ECC_Q = 3;

    /**
     * Error correction level high.
     *
     * 30% of codewords can be restored.
     *
     * @since  2.0.17
     * @var    integer
     */
    const ECC_H = 2;

    /**
     * Numeric encoding (10 bits per 3 digits).
     *
     * Data Capacity: 7089 characters
     *
     * Characters: 0-9
     *
     * Indicator: 0001
     *
     * @since  2.0.17
     * @var    integer
     */
    const NUM = 1;

    /**
     * Alphanumeric encoding (11 bits per 2 characters).
     *
     * Data Capacity: 4296 characters
     *
     * Characters: 0–9 A–Z (upper-case) space $ % * + - , . / :
     *
     * Indicator: 0010
     *
     * @since  2.0.17
     * @var    integer
     */
    const ALPHA = 2;

    /**
     * Byte encoding (8 bits per character).
     *
     * Data Capacity: 2953 bytes
     *
     * Characters: Default encoding: ISO 8859-1 (QR Code 2005)
     *
     * Indicator: 0100
     *
     * @since  2.0.17
     * @var    integer
     */
    const BIN = 4;

    /**
     * Kanji encoding (13 bits per character).
     *
     * Data Capacity: 1817 characters
     *
     * Characters: Shift JIS X 0208
     *
     * Indicator: 1000
     *
     * @since  2.0.17
     * @var    integer
     */
    const KANJI = 8;

    /**
     * Structured append (used to split a message across multiple QR symbols).
     *
     * Indicator: 0011
     *
     * @since  2.0.17
     * @var    integer
     */
    const APP = 3;

    /**
     * Extended Channel Interpretation (select alternate character set or encoding).
     *
     * Indicator: 0111
     *
     * @since  2.0.17
     * @var    integer
     */
    const ECI = 7;

    /**
     * FNC1 in first position (see Code 128 for more information).
     *
     * Indicator: 0101
     *
     * @since  2.0.17
     * @var    integer
     */
    const FNC1_1 = 5;

    /**
     * FNC1 in second position.
     *
     * Indicator: 1001
     *
     * @since  2.0.17
     * @var    integer
     */
    const FNC1_2 = 9;

    /**
     * DEFAULT
     *
     * @since  2.0.17
     * @access private
     *
     * @static
     *
     * @var    array
     */
    private static $cap = array( 208, 359, 567, 807, 1079, 1383, 1568, 1936, 2336, 2768, 3232, 3728, 4256, 4651, 5243, 5867, 6523, 7211, 7931, 8683, 9252, 10068, 10916, 11796, 12708, 13652, 14628, 15371, 16411, 17483, 18587, 19723, 20891, 22091, 23008, 24272, 25568, 26896, 28256, 29648 );

    /**
     * DEFAULT
     *
     * @since  2.0.17
     * @access private
     *
     * @static
     *
     * @var    array
     */
    private static $ver = array( 1 => array( 34, 41, 17, 27, 63, 77, 34, 48, 101, 127, 58, 77, 149, 187, 82, 111, 202, 255, 106, 144, 255, 322, 139, 178, 293, 370, 154, 207, 365, 461, 202, 259, 432, 552, 235, 312, 513, 652, 288, 364, 604, 772, 331, 427, 691, 883, 374, 489, 796, 1022, 427, 580, 871, 1101, 468, 621, 991, 1250, 530, 703, 1082, 1408, 602, 775, 1212, 1548, 674, 876, 1346, 1725, 746, 948, 1500, 1903, 813, 1063, 1600, 2061, 919, 1159, 1708, 2232, 969, 1224, 1872, 2409, 1056, 1358, 2059, 2620, 1108, 1468, 2188, 2812, 1228, 1588, 2395, 3057, 1286, 1718, 2544, 3283, 1425, 1804, 2701, 3514, 1501, 1933, 2857, 3669, 1581, 2085, 3035, 3909, 1677, 2181, 3289, 4158, 1782, 2358, 3486, 4417, 1897, 2473, 3693, 4686, 2022, 2670, 3909, 4965, 2157, 2805, 4134, 5253, 2301, 2949, 4343, 5529, 2361, 3081, 4588, 5836, 2524, 3244, 4775, 6153, 2625, 3417, 5039, 6479, 2735, 3599, 5313, 6743, 2927, 3791, 5596, 7089, 3057, 3993 ), 2 => array( 20, 25, 10, 16, 38, 47, 20, 29, 61, 77, 35, 47, 90, 114, 50, 67, 122, 154, 64, 87, 154, 195, 84, 108, 178, 224, 93, 125, 221, 279, 122, 157, 262, 335, 143, 189, 311, 395, 174, 221, 366, 468, 200, 259, 419, 535, 227, 296, 483, 619, 259, 352, 528, 667, 283, 376, 600, 758, 321, 426, 656, 854, 365, 470, 734, 938, 408, 531, 816, 1046, 452, 574, 909, 1153, 493, 644, 970, 1249, 557, 702, 1035, 1352, 587, 742, 1134, 1460, 640, 823, 1248, 1588, 672, 890, 1326, 1704, 744, 963, 1451, 1853, 779, 1041, 1542, 1990, 864, 1094, 1637, 2132, 910, 1172, 1732, 2223, 958, 1263, 1839, 2369, 1016, 1322, 1994, 2520, 1080, 1429, 2113, 2677, 1150, 1499, 2238, 2840, 1226, 1618, 2369, 3009, 1307, 1700, 2506, 3183, 1394, 1787, 2632, 3351, 1431, 1867, 2780, 3537, 1530, 1966, 2894, 3729, 1591, 2071, 3054, 3927, 1658, 2181, 3220, 4087, 1774, 2298, 3391, 4296, 1852, 2420 ), 4 => array( 14, 17, 7, 11, 26, 32, 14, 20, 42, 53, 24, 32, 62, 78, 34, 46, 84, 106, 44, 60, 106, 134, 58, 74, 122, 154, 64, 86, 152, 192, 84, 108, 180, 230, 98, 130, 213, 271, 119, 151, 251, 321, 137, 177, 287, 367, 155, 203, 331, 425, 177, 241, 362, 458, 194, 258, 412, 520, 220, 292, 450, 586, 250, 322, 504, 644, 280, 364, 560, 718, 310, 394, 624, 792, 338, 442, 666, 858, 382, 482, 711, 929, 403, 509, 779, 1003, 439, 565, 857, 1091, 461, 611, 911, 1171, 511, 661, 997, 1273, 535, 715, 1059, 1367, 593, 751, 1125, 1465, 625, 805, 1190, 1528, 658, 868, 1264, 1628, 698, 908, 1370, 1732, 742, 982, 1452, 1840, 790, 1030, 1538, 1952, 842, 1112, 1628, 2068, 898, 1168, 1722, 2188, 958, 1228, 1809, 2303, 983, 1283, 1911, 2431, 1051, 1351, 1989, 2563, 1093, 1423, 2099, 2699, 1139, 1499, 2213, 2809, 1219, 1579, 2331, 2953, 1273, 1663 ), 8 => array( 8, 10, 4, 7, 16, 20, 8, 12, 26, 32, 15, 20, 38, 48, 21, 28, 52, 65, 27, 37, 65, 82, 36, 45, 75, 95, 39, 53, 93, 118, 52, 66, 111, 141, 60, 80, 131, 167, 74, 93, 155, 198, 85, 109, 177, 226, 96, 125, 204, 262, 109, 149, 223, 282, 120, 159, 254, 320, 136, 180, 277, 361, 154, 198, 310, 397, 173, 224, 345, 442, 191, 243, 384, 488, 208, 272, 410, 528, 235, 297, 438, 572, 248, 314, 480, 618, 270, 348, 528, 672, 284, 376, 561, 721, 315, 407, 614, 784, 330, 440, 652, 842, 365, 462, 692, 902, 385, 496, 732, 940, 405, 534, 778, 1002, 430, 559, 843, 1066, 457, 604, 894, 1132, 486, 634, 947, 1201, 518, 684, 1002, 1273, 553, 719, 1060, 1347, 590, 756, 1113, 1417, 605, 790, 1176, 1496, 647, 832, 1224, 1577, 673, 876, 1292, 1661, 701, 923, 1362, 1729, 750, 972, 1435, 1817, 784, 1024 ) );

    /**
     * Confirmed Arbitrary
     *
     * @since  2.0.17
     * @access private
     *
     * @static
     *
     * @var    array
     */
    private static $ebl = array( array( 1, 16 ), array( 1, 19 ), array( 1, 9 ), array( 1, 13 ), array( 1, 28 ), array( 1, 34 ), array( 1, 16 ), array( 1, 22 ), array( 1, 44 ), array( 1, 55 ), array( 2, 13 ), array( 2, 17 ), array( 2, 32 ), array( 1, 80 ), array( 4, 9 ), array( 2, 24 ), array( 2, 43 ), array( 1, 108 ), array( 2, 11, 2, 12 ), array( 2, 15, 2, 16 ), array( 4, 27 ), array( 2, 68 ), array( 4, 15 ), array( 4, 19 ), array( 4, 31 ), array( 2, 78 ), array( 4, 13, 1, 14 ), array( 2, 14, 4, 15 ), array( 2, 38, 2, 39 ), array( 2, 97 ), array( 4, 14, 2, 15 ), array( 4, 18, 2, 19 ), array( 3, 36, 2, 37 ), array( 2, 116 ), array( 4, 12, 4, 13 ), array( 4, 16, 4, 17 ), array( 4, 43, 1, 44 ), array( 2, 68, 2, 69 ), array( 6, 15, 2, 16 ), array( 6, 19, 2, 20 ), array( 1, 50, 4, 51 ), array( 4, 81 ), array( 3, 12, 8, 13 ), array( 4, 22, 4, 23 ), array( 6, 36, 2, 37 ), array( 2, 92, 2, 93 ), array( 7, 14, 4, 15 ), array( 4, 20, 6, 21 ), array( 8, 37, 1, 38 ), array( 4, 107 ), array( 12, 11, 4, 12 ), array( 8, 20, 4, 21 ), array( 4, 40, 5, 41 ), array( 3, 115, 1, 116 ), array( 11, 12, 5, 13 ), array( 11, 16, 5, 17 ), array( 5, 41, 5, 42 ), array( 5, 87, 1, 88 ), array( 11, 12, 7, 13 ), array( 5, 24, 7, 25 ), array( 7, 45, 3, 46 ), array( 5, 98, 1, 99 ), array( 3, 15, 13, 16 ), array( 15, 19, 2, 20 ), array( 10, 46, 1, 47 ), array( 1, 107, 5, 108 ), array( 2, 14, 17, 15 ), array( 1, 22, 15, 23 ), array( 9, 43, 4, 44 ), array( 5, 120, 1, 121 ), array( 2, 14, 19, 15 ), array( 17, 22, 1, 23 ), array( 3, 44, 11, 45 ), array( 3, 113, 4, 114 ), array( 9, 13, 16, 14 ), array( 17, 21, 4, 22 ), array( 3, 41, 13, 42 ), array( 3, 107, 5, 108 ), array( 15, 15, 10, 16 ), array( 15, 24, 5, 25 ), array( 17, 42 ), array( 4, 116, 4, 117 ), array( 19, 16, 6, 17 ), array( 17, 22, 6, 23 ), array( 17, 46 ), array( 2, 111, 7, 112 ), array( 34, 13 ), array( 7, 24, 16, 25 ), array( 4, 47, 14, 48 ), array( 4, 121, 5, 122 ), array( 16, 15, 14, 16 ), array( 11, 24, 14, 25 ), array( 6, 45, 14, 46 ), array( 6, 117, 4, 118 ), array( 30, 16, 2, 17 ), array( 11, 24, 16, 25 ), array( 8, 47, 13, 48 ), array( 8, 106, 4, 107 ), array( 22, 15, 13, 16 ), array( 7, 24, 22, 25 ), array( 19, 46, 4, 47 ), array( 10, 114, 2, 115 ), array( 33, 16, 4, 17 ), array( 28, 22, 6, 23 ), array( 22, 45, 3, 46 ), array( 8, 122, 4, 123 ), array( 12, 15, 28, 16 ), array( 8, 23, 26, 24 ), array( 3, 45, 23, 46 ), array( 3, 117, 10, 118 ), array( 11, 15, 31, 16 ), array( 4, 24, 31, 25 ), array( 21, 45, 7, 46 ), array( 7, 116, 7, 117 ), array( 19, 15, 26, 16 ), array( 1, 23, 37, 24 ), array( 19, 47, 10, 48 ), array( 5, 115, 10, 116 ), array( 23, 15, 25, 16 ), array( 15, 24, 25, 25 ), array( 2, 46, 29, 47 ), array( 13, 115, 3, 116 ), array( 23, 15, 28, 16 ), array( 42, 24, 1, 25 ), array( 10, 46, 23, 47 ), array( 17, 115 ), array( 19, 15, 35, 16 ), array( 10, 24, 35, 25 ), array( 14, 46, 21, 47 ), array( 17, 115, 1, 116 ), array( 11, 15, 46, 16 ), array( 29, 24, 19, 25 ), array( 14, 46, 23, 47 ), array( 13, 115, 6, 116 ), array( 59, 16, 1, 17 ), array( 44, 24, 7, 25 ), array( 12, 47, 26, 48 ), array( 12, 121, 7, 122 ), array( 22, 15, 41, 16 ), array( 39, 24, 14, 25 ), array( 6, 47, 34, 48 ), array( 6, 121, 14, 122 ), array( 2, 15, 64, 16 ), array( 46, 24, 10, 25 ), array( 29, 46, 14, 47 ), array( 17, 122, 4, 123 ), array( 24, 15, 46, 16 ), array( 49, 24, 10, 25 ), array( 13, 46, 32, 47 ), array( 4, 122, 18, 123 ), array( 42, 15, 32, 16 ), array( 48, 24, 14, 25 ), array( 40, 47, 7, 48 ), array( 20, 117, 4, 118 ), array( 10, 15, 67, 16 ), array( 43, 24, 22, 25 ), array( 18, 47, 31, 48 ), array( 19, 118, 6, 119 ), array( 20, 15, 61, 16 ), array( 34, 24, 34, 25 ) );

    /**
     * DEFAULT
     *
     * @since  2.0.17
     * @access private
     *
     * @static
     *
     * @var    array
     */
    private static $sr = array( 7 => array( 1, 87, 229, 146, 149, 238, 102, 21 ), 10 => array( 1, 251, 67, 46, 61, 118, 70, 64, 94, 32, 45 ), 13 => array( 1, 74, 152, 176, 100, 86, 100, 106, 104, 130, 218, 206, 140, 78 ), 15 => array( 1, 8, 183, 61, 91, 202, 37, 51, 58, 58, 237, 140, 124, 5, 99, 105 ), 16 => array( 1, 120, 104, 107, 109, 102, 161, 76, 3, 91, 191, 147, 169, 182, 194, 225, 120 ), 17 => array( 1, 43, 139, 206, 78, 43, 239, 123, 206, 214, 147, 24, 99, 150, 39, 243, 163, 136 ), 18 => array( 1, 215, 234, 158, 94, 184, 97, 118, 170, 79, 187, 152, 148, 252, 179, 5, 98, 96, 153 ), 20 => array( 1, 17, 60, 79, 50, 61, 163, 26, 187, 202, 180, 221, 225, 83, 239, 156, 164, 212, 212, 188, 190 ), 22 => array( 1, 210, 171, 247, 242, 93, 230, 14, 109, 221, 53, 200, 74, 8, 172, 98, 80, 219, 134, 160, 105, 165, 231 ), 24 => array( 1, 229, 121, 135, 48, 211, 117, 251, 126, 159, 180, 169, 152, 192, 226, 228, 218, 111, 0, 117, 232, 87, 96, 227, 21 ), 26 => array( 1, 173, 125, 158, 2, 103, 182, 118, 17, 145, 201, 111, 28, 165, 53, 161, 21, 245, 142, 13, 102, 48, 227, 153, 145, 218, 70 ), 28 => array( 1, 168, 223, 200, 104, 224, 234, 108, 180, 110, 190, 195, 147, 205, 27, 232, 201, 21, 43, 245, 87, 42, 195, 212, 119, 242, 37, 9, 123 ), 30 => array( 1, 41, 173, 145, 152, 216, 31, 179, 182, 50, 48, 110, 86, 239, 96, 222, 125, 42, 173, 226, 193, 224, 130, 156, 37, 251, 216, 238, 40, 192, 180 ), 32 => array( 1, 10, 6, 106, 190, 249, 167, 4, 67, 209, 138, 138, 32, 242, 123, 89, 27, 120, 185, 80, 156, 38, 69, 171, 60, 28, 222, 80, 52, 254, 185, 220, 241 ), 34 => array( 1, 111, 77, 146, 94, 26, 21, 108, 19, 105, 94, 113, 193, 86, 140, 163, 125, 58, 158, 229, 239, 218, 103, 56, 70, 114, 61, 183, 129, 167, 13, 98, 62, 129, 51 ), 36 => array( 1, 200, 183, 98, 16, 172, 31, 246, 234, 60, 152, 115, 0, 167, 152, 113, 248, 238, 107, 18, 63, 218, 37, 87, 210, 105, 177, 120, 74, 121, 196, 117, 251, 113, 233, 30, 120 ), 40 => array( 1, 59, 116, 79, 161, 252, 98, 128, 205, 128, 161, 247, 57, 163, 56, 235, 106, 53, 26, 187, 174, 226, 104, 170, 7, 175, 35, 181, 114, 88, 41, 47, 163, 125, 134, 72, 20, 232, 53, 35, 15 ), 42 => array( 1, 250, 103, 221, 230, 25, 18, 137, 231, 0, 3, 58, 242, 221, 191, 110, 84, 230, 8, 188, 106, 96, 147, 15, 131, 139, 34, 101, 223, 39, 101, 213, 199, 237, 254, 201, 123, 171, 162, 194, 117, 50, 96 ), 44 => array( 1, 190, 7, 61, 121, 71, 246, 69, 55, 168, 188, 89, 243, 191, 25, 72, 123, 9, 145, 14, 247, 1, 238, 44, 78, 143, 62, 224, 126, 118, 114, 68, 163, 52, 194, 217, 147, 204, 169, 37, 130, 113, 102, 73, 181 ), 46 => array( 1, 112, 94, 88, 112, 253, 224, 202, 115, 187, 99, 89, 5, 54, 113, 129, 44, 58, 16, 135, 216, 169, 211, 36, 1, 4, 96, 60, 241, 73, 104, 234, 8, 249, 245, 119, 174, 52, 25, 157, 224, 43, 202, 223, 19, 82, 15 ), 48 => array( 1, 228, 25, 196, 130, 211, 146, 60, 24, 251, 90, 39, 102, 240, 61, 178, 63, 46, 123, 115, 18, 221, 111, 135, 160, 182, 205, 107, 206, 95, 150, 120, 184, 91, 21, 247, 156, 140, 238, 191, 11, 94, 227, 84, 50, 163, 39, 34, 108 ), 50 => array( 1, 232, 125, 157, 161, 164, 9, 118, 46, 209, 99, 203, 193, 35, 3, 209, 111, 195, 242, 203, 225, 46, 13, 32, 160, 126, 209, 130, 160, 242, 215, 242, 75, 77, 42, 189, 32, 113, 65, 124, 69, 228, 114, 235, 175, 124, 170, 215, 232, 133, 205 ), 52 => array( 1, 116, 50, 86, 186, 50, 220, 251, 89, 192, 46, 86, 127, 124, 19, 184, 233, 151, 215, 22, 14, 59, 145, 37, 242, 203, 134, 254, 89, 190, 94, 59, 65, 124, 113, 100, 233, 235, 121, 22, 76, 86, 97, 39, 242, 200, 220, 101, 33, 239, 254, 116, 51 ), 54 => array( 1, 183, 26, 201, 87, 210, 221, 113, 21, 46, 65, 45, 50, 238, 184, 249, 225, 102, 58, 209, 218, 109, 165, 26, 95, 184, 192, 52, 245, 35, 254, 238, 175, 172, 79, 123, 25, 122, 43, 120, 108, 215, 80, 128, 201, 235, 8, 153, 59, 101, 31, 198, 76, 31, 156 ), 56 => array( 1, 106, 120, 107, 157, 164, 216, 112, 116, 2, 91, 248, 163, 36, 201, 202, 229, 6, 144, 254, 155, 135, 208, 170, 209, 12, 139, 127, 142, 182, 249, 177, 174, 190, 28, 10, 85, 239, 184, 101, 124, 152, 206, 96, 23, 163, 61, 27, 196, 247, 151, 154, 202, 207, 20, 61, 10 ), 58 => array( 1, 82, 116, 26, 247, 66, 27, 62, 107, 252, 182, 200, 185, 235, 55, 251, 242, 210, 144, 154, 237, 176, 141, 192, 248, 152, 249, 206, 85, 253, 142, 65, 165, 125, 23, 24, 30, 122, 240, 214, 6, 129, 218, 29, 145, 127, 134, 206, 245, 117, 29, 41, 63, 159, 142, 233, 125, 148, 123 ), 60 => array( 1, 107, 140, 26, 12, 9, 141, 243, 197, 226, 197, 219, 45, 211, 101, 219, 120, 28, 181, 127, 6, 100, 247, 2, 205, 198, 57, 115, 219, 101, 109, 160, 82, 37, 38, 238, 49, 160, 209, 121, 86, 11, 124, 30, 181, 84, 25, 194, 87, 65, 102, 190, 220, 70, 27, 209, 16, 89, 7, 33, 240 ), 62 => array( 1, 65, 202, 113, 98, 71, 223, 248, 118, 214, 94, 0, 122, 37, 23, 2, 228, 58, 121, 7, 105, 135, 78, 243, 118, 70, 76, 223, 89, 72, 50, 70, 111, 194, 17, 212, 126, 181, 35, 221, 117, 235, 11, 229, 149, 147, 123, 213, 40, 115, 6, 200, 100, 26, 246, 182, 218, 127, 215, 36, 186, 110, 106 ), 64 => array( 1, 45, 51, 175, 9, 7, 158, 159, 49, 68, 119, 92, 123, 177, 204, 187, 254, 200, 78, 141, 149, 119, 26, 127, 53, 160, 93, 199, 212, 29, 24, 145, 156, 208, 150, 218, 209, 4, 216, 91, 47, 184, 146, 47, 140, 195, 195, 125, 242, 238, 63, 99, 108, 140, 230, 242, 31, 204, 11, 178, 243, 217, 156, 213, 231 ), 66 => array( 1, 5, 118, 222, 180, 136, 136, 162, 51, 46, 117, 13, 215, 81, 17, 139, 247, 197, 171, 95, 173, 65, 137, 178, 68, 111, 95, 101, 41, 72, 214, 169, 197, 95, 7, 44, 154, 77, 111, 236, 40, 121, 143, 63, 87, 80, 253, 240, 126, 217, 77, 34, 232, 106, 50, 168, 82, 76, 146, 67, 106, 171, 25, 132, 93, 45, 105 ), 68 => array( 1, 247, 159, 223, 33, 224, 93, 77, 70, 90, 160, 32, 254, 43, 150, 84, 101, 190, 205, 133, 52, 60, 202, 165, 220, 203, 151, 93, 84, 15, 84, 253, 173, 160, 89, 227, 52, 199, 97, 95, 231, 52, 177, 41, 125, 137, 241, 166, 225, 118, 2, 54, 32, 82, 215, 175, 198, 43, 238, 235, 27, 101, 184, 127, 3, 5, 8, 163, 238 ) );

    /**
     * DEFAULT
     *
     * @since  2.0.17
     * @access private
     *
     * @static
     *
     * @var    array
     */
    private static $char = array( array( 1 => 10, 2 => 9, 4 => 8, 8 => 8 ), array( 1 => 12, 2 => 11, 4 => 16, 8 => 10 ), array( 1 => 14, 2 => 13, 4 => 16, 8 => 12 ) );

    /**
     * DEFAULT
     *
     * @since  2.0.17
     * @access private
     *
     * @static
     *
     * @var    array
     */
    private static $alpha = array( '0' => 0, '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, 'A' => 10, 'B' => 11, 'C' => 12, 'D' => 13, 'E' => 14, 'F' => 15, 'G' => 16, 'H' => 17, 'I' => 18, 'J' => 19, 'K' => 20, 'L' => 21, 'M' => 22, 'N' => 23, 'O' => 24, 'P' => 25, 'Q' => 26, 'R' => 27, 'S' => 28, 'T' => 29, 'U' => 30, 'V' => 31, 'W' => 32, 'X' => 33, 'Y' => 34, 'Z' => 35, ' ' => 36, '$' => 37, '%' => 38, '*' => 39, '+' => 40, '-' => 41, '.' => 42, '/' => 43, ' : ' => 44 );

    /**
     * DEFAULT
     *
     * @since  2.0.17
     * @access private
     *
     * @static
     *
     * @var    array
     */
    private static $n2a = array( null, 0, 1, 25, 2, 50, 26, 198, 3, 223, 51, 238, 27, 104, 199, 75, 4, 100, 224, 14, 52, 141, 239, 129, 28, 193, 105, 248, 200, 8, 76, 113, 5, 138, 101, 47, 225, 36, 15, 33, 53, 147, 142, 218, 240, 18, 130, 69, 29, 181, 194, 125, 106, 39, 249, 185, 201, 154, 9, 120, 77, 228, 114, 166, 6, 191, 139, 98, 102, 221, 48, 253, 226, 152, 37, 179, 16, 145, 34, 136, 54, 208, 148, 206, 143, 150, 219, 189, 241, 210, 19, 92, 131, 56, 70, 64, 30, 66, 182, 163, 195, 72, 126, 110, 107, 58, 40, 84, 250, 133, 186, 61, 202, 94, 155, 159, 10, 21, 121, 43, 78, 212, 229, 172, 115, 243, 167, 87, 7, 112, 192, 247, 140, 128, 99, 13, 103, 74, 222, 237, 49, 197, 254, 24, 227, 165, 153, 119, 38, 184, 180, 124, 17, 68, 146, 217, 35, 32, 137, 46, 55, 63, 209, 91, 149, 188, 207, 205, 144, 135, 151, 178, 220, 252, 190, 97, 242, 86, 211, 171, 20, 42, 93, 158, 132, 60, 57, 83, 71, 109, 65, 162, 31, 45, 67, 216, 183, 123, 164, 118, 196, 23, 73, 236, 127, 12, 111, 246, 108, 161, 59, 82, 41, 157, 85, 170, 251, 96, 134, 177, 187, 204, 62, 90, 203, 89, 95, 176, 156, 169, 160, 81, 11, 245, 22, 235, 122, 117, 44, 215, 79, 174, 213, 233, 230, 231, 173, 232, 116, 214, 244, 234, 168, 80, 88, 175 );

    /**
     * DEFAULT
     *
     * @since  2.0.17
     * @access private
     *
     * @static
     *
     * @var    array
     */
    private static $a2n = array( 1, 2, 4, 8, 16, 32, 64, 128, 29, 58, 116, 232, 205, 135, 19, 38, 76, 152, 45, 90, 180, 117, 234, 201, 143, 3, 6, 12, 24, 48, 96, 192, 157, 39, 78, 156, 37, 74, 148, 53, 106, 212, 181, 119, 238, 193, 159, 35, 70, 140, 5, 10, 20, 40, 80, 160, 93, 186, 105, 210, 185, 111, 222, 161, 95, 190, 97, 194, 153, 47, 94, 188, 101, 202, 137, 15, 30, 60, 120, 240, 253, 231, 211, 187, 107, 214, 177, 127, 254, 225, 223, 163, 91, 182, 113, 226, 217, 175, 67, 134, 17, 34, 68, 136, 13, 26, 52, 104, 208, 189, 103, 206, 129, 31, 62, 124, 248, 237, 199, 147, 59, 118, 236, 197, 151, 51, 102, 204, 133, 23, 46, 92, 184, 109, 218, 169, 79, 158, 33, 66, 132, 21, 42, 84, 168, 77, 154, 41, 82, 164, 85, 170, 73, 146, 57, 114, 228, 213, 183, 115, 230, 209, 191, 99, 198, 145, 63, 126, 252, 229, 215, 179, 123, 246, 241, 255, 227, 219, 171, 75, 150, 49, 98, 196, 149, 55, 110, 220, 165, 87, 174, 65, 130, 25, 50, 100, 200, 141, 7, 14, 28, 56, 112, 224, 221, 167, 83, 166, 81, 162, 89, 178, 121, 242, 249, 239, 195, 155, 43, 86, 172, 69, 138, 9, 18, 36, 72, 144, 61, 122, 244, 245, 247, 243, 251, 235, 203, 139, 11, 22, 44, 88, 176, 125, 250, 233, 207, 131, 27, 54, 108, 216, 173, 71, 142, 1 );

    /**
     * DEFAULT
     *
     * @since  2.0.17
     * @access public
     *
     * @param  string  $data Contains the QR code content.
     * @param  integer $ecc  Contains the error correction level.
     */
    public function __construct( $data, $ecc = self::ECC_M )
    {
        $this->prepare( (string) $data, (integer) $ecc );

        $this->frame();

        $this->reed_solomon_code();

        $this->mask();

        $this->format();
    }

    /**
     * DEFAULT
     *
     * @since  2.0.17
     * @access public
     */
    public function getDigit()
    {
        return $this->array_of_modules;
    }

    /**
     * DEFAULT
     *
     * @since  2.0.17
     * @access private
     *
     * @param  integer/string/array $DEFAULT DEFAULT
     * @param  integer/string/array $DEFAULT DEFAULT
     */
    private function prepare( $data, $ecc )
    {
        //-------------------------------------------------
        // Validate Data
        //-------------------------------------------------

        $this->type = self::BIN;

        $ecc = min( max( intval( $ecc ), self::ECC_M ), self::ECC_Q );

        if ( ! preg_match( '{[^0-9]}', $data ) )
        {
            $this->type = self::NUM;
        }
        else if ( ! preg_match( '{[^A-Z0-9 $%*+\-./:]}', $data ) )
        {
            $this->type = self::ALPHA;
        }
        else if ( mb_detect_encoding( $data, 'SJIS', true ) && preg_match( '{[\x81-\x9F\xE0-\xEF]}', $data ) )
        {
            $this->type = self::KANJI;
        }

        //-------------------------------------------------
        // Check string length
        //-------------------------------------------------

        $ver = 0;

        $content_count = strlen( $data );

        while ( $ver != 40 )
        {
            if ( self::$ver[ $this->type ][ $ver * 4 + $ecc ] > $content_count )
            {
                break;
            }

            $ver++;
        }

        if ( $ver == 40 )
        {
            die ( 'String Length Exceeded for Datatype ' . $this->type );
        }

        $this->vers = $ver;

        $this->module_count = 4 * ( $ver + 1 ) + 17;

        //-------------------------------------------------
        // Register properties
        //-------------------------------------------------

        $this->ecc = $ecc;

        $this->array_of_modules = str_split( str_pad( '', pow( $this->module_count, 2 ), '4' ), $this->module_count );

        $this->data = $data;

        $c = strlen( $data );

        $rem = '';

        //-------------------------------------------------
        // Begin formatting data
        //-------------------------------------------------

        switch ( $this->type )
        {
            case self::NUM:
            {
                $data = str_split( $data, 3 );

                if ( $c % 3 != 0 )
                {
                    $rem = self::bits( intval( array_pop( $data ) ), ( $c % 3 ) * 3 + 1 );
                }

                foreach ( $data as &$d )
                {
                    $d = self::bits( intval( $d ), 10 );
                }

                $data[] = $rem;
            }
            break;
            case self::ALPHA:
            {
                $data = str_split( $data, 2 );

                if ( $c % 2 == 1 )
                {
                    $rem = self::bits( self::$alpha[ array_pop( $data ) ], 6 );
                }

                foreach ( $data as &$d )
                {
                    $d = self::bits( self::$alpha[ $d[ 0 ] ] * 45 + self::$alpha[ $d[ 1 ] ], 11 );
                }

                $data[] = $rem;
            }
            break;
            case self::BIN:
            {
                $data = str_split( $data );

                foreach ( $data as &$d )
                {
                    $d = self::bits( ord( $d ), 8 );
                }
            }
            break;
            case self::KANJI:
            {
                $data = str_split( $data, 2 );

                foreach ( $data as &$d )
                {
                    if ( $d >= 0xe040 )
                    {
                        $d -= 0xc140;
                    }
                    else
                    {
                        $d -= 0x8140;
                    }

                    $d = self::bits( ( $d >> 8 ) * 0xC0 + ( $d & 0xFF ), 13 );
                }
            }
            break;
        }

        //-------------------------------------------------
        // Combine strings
        //-------------------------------------------------

        $this->data = self::bits( $this->type, 4 ) . self::bits( $c, self::$char[ floor( $this->vers / 17 + 7 / 17 ) ][ $this->type ] ) . implode( '', $data );

        $cap = self::$ebl[ $this->vers * 4 + $this->ecc ];

        $cap = ( $cap[ 0 ] * $cap[ 1 ] + ( isset( $cap[ 2 ] ) ? $cap[ 2 ] * $cap[ 3 ] : 0 ) ) * 8;

        $rem = $cap - strlen( $this->data );

        //-------------------------------------------------
        // Terminate, pad, split
        //-------------------------------------------------

        if ( $rem > 0 )
        {
            $this->data .= str_pad( '', min( 4, $rem ), '0' );

            $this->data .= str_pad( '', 8 - strlen( $this->data ) % 8, '0' );

            $this->data .= str_pad( '', $cap - strlen( $this->data ), '11101100' . '00010001' );
        }

        $this->data = str_split( $this->data, 8 );

        foreach ( $this->data as &$d )
        {
            $d = bindec( $d );
        }
    }

    /**
     * DEFAULT
     *
     * @since  2.0.17
     * @access private
     */
    private function frame()
    {
        //-------------------------------------------------
        // Initialize frame
        //-------------------------------------------------

        $align = '11111100' . '01101011' . '00011111' . '1';

        $time = str_pad( '', $this->module_count - 14, '01' );

        $pos = '11111111' . '00000110' . '11101101' . '11011011' . '10110000' . '01111111' . '1';

        $blank = str_pad( '', 8, '0' );

        $this->place( $pos, 7, 0, 0 );

        $this->place( $pos, 7, $this->module_count - 7, 0 );

        //-------------------------------------------------
        // Position
        //-------------------------------------------------

        $this->place( $pos, 7, 0, $this->module_count - 7 );

        $this->place( $blank, 1, $this->module_count - 8, 0 );

        //-------------------------------------------------
        // Format Regions
        //-------------------------------------------------

        $this->place( $blank, 8, 0, $this->module_count - 8 );

        $blank .= $blank;

        $this->place( $blank, 8, $this->module_count - 8, 7 );

        $this->place( $blank, 2, 7, $this->module_count - 8 );

        $this->place( $blank, 2, 7, 0 );

        $blank .= '00';

        $this->place( $blank, 9, 0, 7 );

        //-------------------------------------------------
        // Timing, Dark Module
        //-------------------------------------------------

        $this->place( $time, $this->module_count - 14, 7, 6 );

        $this->place( $time, 1, 6, 7 );

        $this->array_of_modules[ $this->module_count - 8 ][ 8 ] = '1';

        if ( $this->vers > 0 )
        {
            $this->place( $align, 5, $this->module_count - 9, $this->module_count - 9 );

            //-------------------------------------------------
            // Alignment
            //-------------------------------------------------

            if ( $this->vers > 5 )
            {
                $a = floor( ( $this->module_count - 17 ) / 28 ) + 2;

                $p = intval( ( $this->module_count - 13 ) / ( $a - 1 ) );

                $c = 0;

                while ( $c < $a )
                {
                    $r = 0;

                    if ( $c == 0 || $c == $a - 1 )
                    {
                        $r = 1;
                    }

                    while ( $r < $a )
                    {
                        $this->place( $align, 5, $p * $c + 4, $p * $r + 4 );

                        $r++;

                        if ( $r == $a - 1 && ( $c == 0 || $c == $a - 1 ) )
                        {
                            break;
                        }
                    }

                    $c++;
                }

                //-------------------------------------------------
                // Version Regions
                //-------------------------------------------------

                $this->place( $blank, 3, $this->module_count - 11, 0 );

                $this->place( $blank, 6, 0, $this->module_count - 11 );
            }
        }
    }

    /**
     * Reed–Solomon codes are an important group of error-correcting codes that were introduced by Irving S. Reed and Gustave Solomon in 1960.
     *
     * 0, 1 = frame, 2, 3 = data, 4 = empty
     *
     * @since  2.0.17
     * @access private
     */
    private function reed_solomon_code()
    {
        $b = self::$ebl[ $this->vers * 4 + $this->ecc ];

        //-------------------------------------------------
        // Get ECC structure
        //-------------------------------------------------

        $c = $b[ 0 ] + ( isset( $b[ 2 ] ) ? $b[ 2 ] : 0 );

        $d = $b[ 0 ] * $b[ 1 ] + ( isset( $b[ 2 ] ) ? $b[ 2 ] * $b[ 3 ] : 0 );

        $e = ( floor( self::$cap[ $this->vers ] / 8 ) - $d ) / $c;

        $ecc = array();

        //-------------------------------------------------
        // Process, build
        //-------------------------------------------------

        foreach ( array_chunk( $b, 2 ) as $a )
        {
            for ( $i = 0; $i < $a[ 0 ]; $i++ )
            {
                $ecc[ 'd' ][] = array_splice( $this->data, 0, $a[ 1 ] );

                $ecc[ 'e' ][] = self::crc2( end( $ecc[ 'd' ] ), $e );
            }
        }

        $e *= $c;

        $this->data = '';

        $d = $c * $b[ 1 ];

        //-------------------------------------------------
        // Reorganize, decimal to binary
        //-------------------------------------------------

        for ( $i = 0; $i < $d; $i++ )
        {
            $this->data .= self::bits( array_shift( $ecc[ 'd' ][ $i % $c ] ), 8 );
        }

        if ( isset( $b[ 2 ] ) )
        {
            for ( $i = $b[ 0 ]; $i < $c; $i++ )
            {
                $this->data .= self::bits( array_shift( $ecc[ 'd' ][ $i % $c ] ), 8 );
            }
        }

        for ( $i = 0; $i < $e; $i++ )
        {
            $this->data .= self::bits( array_shift( $ecc[ 'e' ][ $i % $c ] ), 8 );
        }

        $this->data .= str_pad( '', self::$cap[ $this->vers ] % 8, '0' );

        //-------------------------------------------------
        // Remainder Bits
        //-------------------------------------------------

        $this->data = str_replace( array( '0', '1' ), array( '2', '3' ), $this->data );

        //-------------------------------------------------
        // Write to temp
        //-------------------------------------------------

        $a = array( array( $this->module_count - 1, - 1, - 1 ), array( 0, $this->module_count, 1 ) );

        $b = reset( $a );

        $e = 0;

        for ( $c = $this->module_count - 1; $c > 0; $c -= 2 )
        {
            if ( $c == 6 )
            {
                $c--;
            }

            //-------------------------------------------------
            // Skip vertical timing column?
            //-------------------------------------------------

            for ( $d = $b[ 0 ]; $d != $b[ 1 ]; $d += $b[ 2 ] )
            {
                if ( $this->array_of_modules[ $d ][ $c ] == '4' )
                {
                    $this->array_of_modules[ $d ][ $c ] = $this->data[ $e ];

                    $e++;
                }

                if ( $this->array_of_modules[ $d ][ $c - 1 ] == '4' )
                {
                    $this->array_of_modules[ $d ][ $c - 1 ] = $this->data[ $e ];

                    $e++;
                }
            }

            $b = ( $b[ 0 ] ) ? end( $a ) : reset( $a );
        }
    }

    /**
     * When encoding a QR code, there are eight mask patterns that you can use to change the outputted matrix. Each mask pattern changes the bits according to their coordinates in the QR matrix. The purpose of a mask pattern is to make the QR code easier for a QR scanner to read.
     *
     * @since  2.0.17
     * @access private
     */
    private function mask()
    {
        $array_of_masks = array();

        $scores = array();

        //-------------------------------------------------
        // Try all masks
        //-------------------------------------------------

        for ( $m = 0; $m < 8; $m++ )
        {
            $array_of_masks[ $m ] = $this->array_of_modules;

            $scores[ $m ] = array( array(), 0, 0, 0 );

            switch( $m )
            {
                case 0:
                {
                    for ( $i = 0; $i < $this->module_count; $i++ )
                    {
                        for ( $j = 0; $j < $this->module_count; $j++ )
                        {
                            if ( ( $i + $j ) % 2 == 0 && $array_of_masks[ $m ][ $j ][ $i ] > 1 )
                            {
                                $array_of_masks[ $m ][ $j ][ $i ] = ( $array_of_masks[ $m ][ $j ][ $i ] % 2 ) ? '0' : '1';
                            }
                        }
                    }
                }
                break;
                case 1:
                {
                    for ( $i = 0; $i < $this->module_count; $i++ )
                    {
                        for ( $j = 0; $j < $this->module_count; $j++ )
                        {
                            if ( $j % 2 == 0 && $array_of_masks[ $m ][ $j ][ $i ] > 1 )
                            {
                                $array_of_masks[ $m ][ $j ][ $i ] = ( $array_of_masks[ $m ][ $j ][ $i ] % 2 ) ? '0' : '1';
                            }
                        }
                    }
                }
                break;
                case 2:
                {
                    for ( $i = 0; $i < $this->module_count; $i++ )
                    {
                        for ( $j = 0; $j < $this->module_count; $j++ )
                        {
                            if ( $i % 3 == 0 && $array_of_masks[ $m ][ $j ][ $i ] > 1 )
                            {
                                $array_of_masks[ $m ][ $j ][ $i ] = ( $array_of_masks[ $m ][ $j ][ $i ] % 2 ) ? '0' : '1';
                            }
                        }
                    }
                }
                break;
                case 3:
                {
                    for ( $i = 0; $i < $this->module_count; $i++ )
                    {
                        for ( $j = 0; $j < $this->module_count; $j++ )
                        {
                            if ( ( $i + $j ) % 3 == 0 && $array_of_masks[ $m ][ $j ][ $i ] > 1 )
                            {
                                $array_of_masks[ $m ][ $j ][ $i ] = ( $array_of_masks[ $m ][ $j ][ $i ] % 2 ) ? '0' : '1';
                            }
                        }
                    }
                }
                break;
                case 4:
                {
                    for ( $i = 0; $i < $this->module_count; $i++ )
                    {
                        for ( $j = 0; $j < $this->module_count; $j++ )
                        {
                            if ( ( ( $i >> 1 ) + ( int )( $j / 3 ) ) % 2 == 0 && $array_of_masks[ $m ][ $j ][ $i ] > 1 )
                            {
                                $array_of_masks[ $m ][ $j ][ $i ] = ( $array_of_masks[ $m ][ $j ][ $i ] % 2 ) ? '0' : '1';
                            }
                        }
                    }
                }
                break;
                case 5:
                {
                    for ( $i = 0; $i < $this->module_count; $i++ )
                    {
                        for ( $j = 0; $j < $this->module_count; $j++ )
                        {
                            if ( $i * $j % 2 + $i * $j % 3 == 0 && $array_of_masks[ $m ][ $j ][ $i ] > 1 )
                            {
                                $array_of_masks[ $m ][ $j ][ $i ] = ( $array_of_masks[ $m ][ $j ][ $i ] % 2 ) ? '0' : '1';
                            }
                        }
                    }
                }
                break;
                case 6:
                {
                    for ( $i = 0; $i < $this->module_count; $i++ )
                    {
                        for ( $j = 0; $j < $this->module_count; $j++ )
                        {
                            if ( ( $i * $j % 2 + $i * $j % 3 ) % 2 == 0 && $array_of_masks[ $m ][ $j ][ $i ] > 1 )
                            {
                                $array_of_masks[ $m ][ $j ][ $i ] = ( $array_of_masks[ $m ][ $j ][ $i ] % 2 ) ? '0' : '1';
                            }
                        }
                    }
                }
                break;
                case 7:
                {
                    for ( $i = 0; $i < $this->module_count; $i++ )
                    {
                        for ( $j = 0; $j < $this->module_count; $j++ )
                        {
                            if ( ( $i * $j % 3 + $i * $j % 2 ) % 2 == 0 && $array_of_masks[ $m ][ $j ][ $i ] > 1 )
                            {
                                $array_of_masks[ $m ][ $j ][ $i ] = ( $array_of_masks[ $m ][ $j ][ $i ] % 2 ) ? '0' : '1';
                            }
                        }
                    }
                }
                break;
            }

            //-------------------------------------------------
            // Process and score
            //-------------------------------------------------

            $array_of_masks[ $m ] = explode( ', ', str_replace( array( '2', '3' ), array( '0', '1' ), implode( ', ', $array_of_masks[ $m ] ) ) );

            foreach ( $array_of_masks[ $m ] as $a )
            {
                $scores[ $m ][ 2 ] += substr_count( $a, '1011101' );

                preg_match_all( '/1{5,}/', $a, $b );

                $scores[ $m ][ 0 ] = array_merge( $scores[ $m ][ 0 ], $b[ 0 ] );

                $a = count_chars( $a );

                $scores[ $m ][ 3 ] += $a[ 49 ];
            }

            //-------------------------------------------------
            // Transpose for vertical regions
            //-------------------------------------------------

            foreach ( self::transpose( $array_of_masks[ $m ], $this->module_count, true ) as $a )
            {
                $scores[ $m ][ 2 ] += substr_count( $a, '1011101' );

                preg_match_all( '/1{5,}/', $a, $b );

                $scores[ $m ][ 0 ] = array_merge( $scores[ $m ][ 0 ], $b[ 0 ] );
            }

            foreach ( $scores[ $m ][ 0 ] as &$a )
            {
                $a = strlen( $a ) - 5;
            }

            $scores[ $m ][ 0 ] = max( $scores[ $m ][ 0 ] );

            //-------------------------------------------------
            // Process data
            //-------------------------------------------------

            $scores[ $m ][ 3 ] = round( abs( 100 * $scores[ $m ][ 3 ] / pow( $this->module_count, 2 ) - 50 ) / 5 ) * 5;

            $scores[ $m ] = 3 + $scores[ $m ][ 0 ] + 40 * $scores[ $m ][ 2 ] + 10 * $scores[ $m ][ 3 ];
        }

        //-------------------------------------------------
        // Choose mask
        //-------------------------------------------------

        $m = array_keys( $scores, min( $scores ) );

        $this->mask_index = $m[ 0 ];

        $this->array_of_modules = $array_of_masks[ $this->mask_index ];
    }

    /**
     * The QR code's size is represented by a number, called a version number. To ensure that a QR code scanner accurately decodes what it scans, the QR code specification requires that each code include a format information string, which tells the QR code scanner which error correction level and mask pattern the QR code is using. In addition, for version 7 and larger, the QR code specification requires that each code include a version information string, which tells the QR code scanner which version the code is.
     *
     * @since  2.0.17
     * @access private
     */
    private function format()
    {
        //-------------------------------------------------
        // Build format string
        //-------------------------------------------------

        $f = $this->mask_index + ( $this->ecc << 3 );

        $f = self::bits( ( self::crc( $f, 1335 ) + ( $f << 10 ) ) ^ 21522, 15 );

        $this->place( substr( $f, 7, 8 ), 8, $this->module_count - 8, 8 );

        $this->place( strrev( substr( $f, 0, 7 ) ), 1, 8, $this->module_count - 7 );

        $this->place( strrev( substr( $f, 9, 6 ) ), 1, 8, 0 );

        $this->place( strrev( substr( $f, 7, 2 ) ), 1, 8, 7 );

        $this->place( substr( $f, 6, 1 ), 1, 7, 8 );

        $this->place( substr( $f, 0, 6 ), 6, 0, 8 );

        //-------------------------------------------------
        // Build version string
        //-------------------------------------------------

        if ( $this->vers > 5 )
        {
            $v = $this->vers + 1;

            $v = strrev( self::bits( self::crc( $v, 7973 ) + ( $v << 12 ), 18 ) );

            $this->place( $v, 3, $this->module_count - 11, 0 );

            $this->place( self::transpose( $v, 3 ), 6, 0, $this->module_count - 11 );
        }
    }

    /**
     * DEFAULT
     *
     * @since  2.0.17
     * @access private
     *
     * @param  string  $data  DEFAULT
     * @param  string  $phase DEFAULT
     * @param  integer $x     DEFAULT
     * @param  integer $y     DEFAULT
     */
    private function place( $data, $phase, $x, $y )
    {
        $data = str_split( $data, $phase );

        foreach ( $data as $d )
        {
            for ( $i = 0; $i < $phase; $i++ )
            {
                $this->array_of_modules[ $y ][ $i + $x ] = $d[ $i ];
            }

            $y++;
        }
    }

    /**
     * DEFAULT
     *
     * @since  2.0.17
     * @access private
     *
     * @static
     *
     * @param  integer/string/array $DEFAULT DEFAULT
     * @param  integer/string/array $DEFAULT DEFAULT
     *
     * @return integer/string/array $DEFAULT DEFAULT
     */
    private static function crc( $m, $k )
    {
        $a = strlen( decbin( $m ) );

        $l = strlen( decbin( $k ) ) - 1;

        $m = $m << $l;

        while ( $a >- 1 )
        {
            if ( $m & 1 << $l + $a )
            {
                $m = $m ^ ( $k << $a );
            }

            $a--;
        }

        return $m;
    }

    /**
     * DEFAULT
     *
     * @since  2.0.17
     * @access private
     *
     * @static
     *
     * @param  array   $d DEFAULT
     * @param  integer $b DEFAULT
     *
     * @return integer/string/array $DEFAULT DEFAULT
     */
    private static function crc2( $d, $b )
    {
        $d = array_values( $d );

        $i = count( $d );

        $g = self::$sr[ $b ];

        $j = count( $g ) - 1;

        $d = array_pad( $d, $j + $i, 0 );

        while ( $i > 0 )
        {
            $b = self::$n2a[ $d[ 0 ] ];

            array_shift( $d );

            for ( $c = 0; $c < $j; $c++ )
            {
                $d[ $c ] = $d[ $c ] ^ ( self::$a2n[ ( $b + $g[ $c + 1 ] ) % 255 ] );
            }

            $i--;
        }

        return $d;
    }

    /**
     * DEFAULT
     *
     * @since  2.0.17
     * @access private
     *
     * @static
     *
     * @param  integer $d DEFAULT
     * @param  integer $l DEFAULT
     *
     * @return string DEFAULT
     */
    private static function bits( $d, $l )
    {
        return str_pad( decbin( $d ), $l, '0', STR_PAD_LEFT );
    }

    /**
     * DEFAULT
     *
     * @since  2.0.17
     * @access private
     *
     * @static
     *
     * @param  array   $a   DEFAULT
     * @param  integer $b   DEFAULT
     * @param  boolean $arr DEFAULT
     *
     * @return string|array  DEFAULT
     */
    private static function transpose( $a, $b, $arr = false )
    {
        $a = ( $arr ) ? $a : str_split( $a, $b );

        $c = count( $a );

        $j = 0;

        $t = '';

        while ( $j < $b )
        {
            $i = 0;

            while ( $i < $c )
            {
                $t .= $a[ $i ][ $j ];

                $i++;
            }

            $j++;
        }

        return ( $arr ) ? str_split( $t, $b ) : $t;
    }
}
?>