<?php


class ColorPalettes
{

    /**
     * @var array - array of palettes
     */
    public $palettes;

    /**
     * @var string - style of palettes to return
     */
    public $style = "";

    /**
     * @var string - name of the current master palette
     */
    public $current_palette = "";


    public function __construct($specific_palette = "", $style = "regular")
    {

        // Set the style
        $this->style = $style;

        // If we're only after a specific palette...
        if (strlen($specific_palette) > 1) {
            // Something...
        } // We want ALL the colors
        else {


            $this->create_all();

        }

    }

    /**
     * Create all the palettes
     */
    public function create_all()
    {

        // Get dynamic palette
        $this->create_dynamic();

        // Initialize Younique colors
        //$this->create_younique();

        // Initialize Younique colors
        //$this->create_denominee();

        // Finish with the grays palette
        $this->create_grays();

//		echo '<pre>';
//		print_r($this->palettes);
//		echo '</pre>';
//		die();
    }

    public function create_dynamic()
    {

        // Get the palette name
        $this->current_palette = get_field('palette_name', 'option');

        // Make sure we have a palette name...
        if (strlen($this->current_palette) > 1) {

            // Get all the palettes
            $all_palettes_string = get_field('palettes', 'option');

            // Break up the palettes by line
            $palettes_by_line = explode("\n", $all_palettes_string);

            // Loop through each palette
            foreach ($palettes_by_line as $palette_line) {

                // Remove junk characters
                $palette_line = preg_replace('/\s+/', ' ', trim($palette_line));

                // Break up by commas
                $palette = explode(',', $palette_line);

                $palette[0] = preg_replace('/\s+/', ' ', trim($palette[0]));
                $palette[1] = preg_replace('/\s+/', ' ', trim($palette[1]));
                $palette[2] = preg_replace('/\s+/', ' ', trim($palette[2]));
                $palette[3] = preg_replace('/\s+/', ' ', trim($palette[3]));

                // Add the palette
                $this->palettes[$this->current_palette][] = $this->create_palette($palette[0], $palette[1], $palette[2], $palette[3]);

            }

        }

    }

    public function create_younique()
    {

        // Set the master palette
        $this->current_palette = "younique";

        // Initialize current master palette
        $this->palettes[$this->current_palette] = array();

        $this->palettes[$this->current_palette][] = $this->create_palette('primary', 900, '#F17F02', '#FFFFFF');
        $this->palettes[$this->current_palette][] = $this->create_palette('primary', 500, '#e4a834', '#FFFFFF');
        $this->palettes[$this->current_palette][] = $this->create_palette('primary', 100, '#FAF2E7', '#F17F02');

        $this->palettes[$this->current_palette][] = $this->create_palette('secondary', 900, '#143d4c', '#FFFFFF');
        $this->palettes[$this->current_palette][] = $this->create_palette('secondary', 500, '#7797a4', '#FFFFFF');
        $this->palettes[$this->current_palette][] = $this->create_palette('secondary', 100, '#ccd2d4', '#143d4c');

        $this->palettes[$this->current_palette][] = $this->create_palette('tertiary', 900, '#989e6c', '#FFFFFF');
        $this->palettes[$this->current_palette][] = $this->create_palette('tertiary', 500, '#C6C9AF', '#FFFFFF');
        $this->palettes[$this->current_palette][] = $this->create_palette('tertiary', 100, '#F4F5F0', '#989e6c');

    }

    public function create_denominee()
    {

        // Set the master palette
        $this->current_palette = "denominee";

        // Initialize current master palette
        $this->palettes[$this->current_palette] = array();

        $this->palettes[$this->current_palette][] = $this->create_palette('primary', 100, '#F8E6E6', '#FFFFFF');
        $this->palettes[$this->current_palette][] = $this->create_palette('primary', 600, '#E51E0A', '#FFFFFF');
        $this->palettes[$this->current_palette][] = $this->create_palette('primary', 700, '#B31B24', '#FFFFFF');
        $this->palettes[$this->current_palette][] = $this->create_palette('primary', 800, '#812427', '#FFFFFF');
        $this->palettes[$this->current_palette][] = $this->create_palette('primary', 900, '#512223', '#FFFFFF');

        $this->palettes[$this->current_palette][] = $this->create_palette('secondary', 900, '#8DD0C8', '#FFFFFF');
        $this->palettes[$this->current_palette][] = $this->create_palette('secondary', 500, '#a8d6d0', '#FFFFFF');
        $this->palettes[$this->current_palette][] = $this->create_palette('secondary', 100, '#c8e8e4', '#143d4c');

    }

    /**
     * Create the gray palette
     */
    public function create_grays()
    {

        // Set the master palette
        $this->current_palette = "gray";

        // Initialize current master palette
        $this->palettes[$this->current_palette] = array();

        $this->palettes[$this->current_palette][] = $this->create_palette('gray', 900, '#333333', '#FFF');
        $this->palettes[$this->current_palette][] = $this->create_palette('gray', 800, '#3D3D3D', '#FFF');
        $this->palettes[$this->current_palette][] = $this->create_palette('gray', 700, '#474747', '#FFF');
        $this->palettes[$this->current_palette][] = $this->create_palette('gray', 600, '#606060', '#FFF');
        $this->palettes[$this->current_palette][] = $this->create_palette('gray', 500, '#707070', '#FFF');
        $this->palettes[$this->current_palette][] = $this->create_palette('gray', 400, '#7E7E7E', '#FFF');
        $this->palettes[$this->current_palette][] = $this->create_palette('gray', 300, '#CFCFCF', '#333');
        $this->palettes[$this->current_palette][] = $this->create_palette('gray', 200, '#DBDBDB', '#333');
        $this->palettes[$this->current_palette][] = $this->create_palette('gray', 100, '#F3F3F3', '#333');
        $this->palettes[$this->current_palette][] = $this->create_palette('gray', 1, '#FFFFFF', '#333');







    }


    /**
     * Create an object with colors
     * @param string $name - label for the color
     * @param int $weight - weight of the color
     * @param string $color - hex code for color
     * @param string $opposite - hex code for color
     *
     * @return array
     */
    public function create_palette($name, $weight, $color, $opposite)
    {

        // Get the name
        $name_of_color = $this->current_palette . ' ' . $name . ' ' . $weight;
        $slug_of_color = sanitize_title($name_of_color);

        // If the style is REGULAR
        if ($this->style === 'regular') {

            // Create the object
            $colors['name'] = $name_of_color;
            $colors['slug'] = $slug_of_color;
            $colors['weight'] = $weight;
            $colors['color'] = $color;
            $colors['opposite'] = $opposite;

            return $colors;

        } else {



            return array(
                'name' => $name_of_color,
                'slug' => $slug_of_color,
                'color' => $color
            );

        }

    }




    // -- CSS CLASSES -- //

    public static function get_background_css($color, $has_text = false) {

        // Create the BG classes
        $classes = "has-background has-".$color."-background-color";

        // If we are requesting the TEXT color too
        if($has_text === true) {
            $classes .= ' has-text-color has-'.$color.'-opposite-color';
        }

        return $classes;

    }

    public static function get_text_css($color, $has_background = false) {

        // Create the BG classes
        $classes = "has-text-color has-".$color."-color";

        // If we are requesting the BG color too
        if($has_background === true) {
            $classes .= ' has-background has-'.$color.'-opposite-background-color';
        }

        return $classes;

    }






    // -- COLOR CONVERSIONS -- //

    public static function RGBtoHSV($R, $G, $B) {
        // Convert the RGB byte-values to percentages
        $R = ($R / 255);
        $G = ($G / 255);
        $B = ($B / 255);

        // Calculate a few basic values, the maximum value of R,G,B, the
        //   minimum value, and the difference of the two (chroma).
        $maxRGB = max($R, $G, $B);
        $minRGB = min($R, $G, $B);
        $chroma = $maxRGB - $minRGB;

        // Value (also called Brightness) is the easiest component to calculate,
        //   and is simply the highest value among the R,G,B components.
        // We multiply by 100 to turn the decimal into a readable percent value.
        $computedV = 100 * $maxRGB;

        // Special case if hueless (equal parts RGB make black, white, or grays)
        // Note that Hue is technically undefined when chroma is zero, as
        //   attempting to calculate it would cause division by zero (see
        //   below), so most applications simply substitute a Hue of zero.
        // Saturation will always be zero in this case, see below for details.
        if ($chroma == 0)
            return array(0, 0, $computedV);

        // Saturation is also simple to compute, and is simply the chroma
        //   over the Value (or Brightness)
        // Again, multiplied by 100 to get a percentage.
        $computedS = 100 * ($chroma / $maxRGB);

        // Calculate Hue component
        // Hue is calculated on the "chromacity plane", which is represented
        //   as a 2D hexagon, divided into six 60-degree sectors. We calculate
        //   the bisecting angle as a value 0 <= x < 6, that represents which
        //   portion of which sector the line falls on.
        if ($R == $minRGB)
            $h = 3 - (($G - $B) / $chroma);
        elseif ($B == $minRGB)
            $h = 1 - (($R - $G) / $chroma);
        else // $G == $minRGB
            $h = 5 - (($B - $R) / $chroma);

        // After we have the sector position, we multiply it by the size of
        //   each sector's arc (60 degrees) to obtain the angle in degrees.
        $computedH = 60 * $h;

        return array($computedH, $computedS, $computedV);
    }

    public static function HEXtoRGB($hex, $alpha = false) {
        $hex      = str_replace('#', '', $hex);
        $length   = strlen($hex);
        $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
        $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
        $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
        if ( $alpha ) {
            $rgb['a'] = $alpha;
        }
        return $rgb;
    }

    public static function HSVtoRGB($H, $S, $V) {

        //1
        $H *= 6;
        //2
        $I = floor($H);
        $F = $H - $I;
        //3
        $M = $V * (1 - $S);
        $N = $V * (1 - $S * $F);
        $K = $V * (1 - $S * (1 - $F));
        //4
        switch ($I) {
            case 0:
                list($R,$G,$B) = array($V,$K,$M);
                break;
            case 1:
                list($R,$G,$B) = array($N,$V,$M);
                break;
            case 2:
                list($R,$G,$B) = array($M,$V,$K);
                break;
            case 3:
                list($R,$G,$B) = array($M,$N,$V);
                break;
            case 4:
                list($R,$G,$B) = array($K,$M,$V);
                break;
            case 5:
            case 6: //for when $H=1 is given
                list($R,$G,$B) = array($V,$M,$N);
                break;
        }
        return array (
            'r' => $R,
            'g' => $G,
            'b' => $B
        );
    }

}

