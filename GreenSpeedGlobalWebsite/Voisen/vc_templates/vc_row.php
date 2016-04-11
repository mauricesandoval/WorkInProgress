<?php
$output = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = $css = '';
extract(shortcode_atts(array(
    'el_class'        => '',
    'bg_image'        => '',
    'bg_color'        => '',
    'bg_image_repeat' => '',
    'font_color'      => '',
    'padding'         => '',
    'margin_bottom'   => '',
    'fullwidth'       => '0',
    'parallax'        => '0',
    'css'             => '',
    'rowsm'           => false,
    'footer_css'      => ''
), $atts));
$footer_class='';
if($footer_css!=''){
    $footer_class = ' '.voisen_vc_custom_css_class( $footer_css, ' ' );
    echo '<style>'.$footer_css.'</style>';
}

$_is_container = ($fullwidth=='1' && $parallax=='1') ? true:false;
$row_sm = ($rowsm) ? ' row-sm' : '';

$is_parallax = ($parallax!='0')?' data-stellar-background-ratio="0.6"':'';
$el_class = $this->getExtraClass($el_class).$footer_class;
$parallax = ($parallax!='0') ? ' parallax' : '';
$style = $this->buildStyle($bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);
$output = '';
$fullwidth_class = ($fullwidth!='0') ? ' fullwidth' : '';
if($this->settings('base')==='vc_row'){
    $output.='<div class="section-element' . $fullwidth_class . $el_class . $parallax.voisen_vc_custom_css_class($css, ' ').'" '.$style.$is_parallax.'>';
        $output .= ($fullwidth!='0') ? '' : '<div class="container">';
        $output .= ($_is_container)?'<div class="container">':'';
            $output .= '<div class="row'.$row_sm.'">';
                $output .= wpb_js_remove_wpautop($content);
            $output .= '</div>'.$this->endBlockComment('row');
        $output .= ($fullwidth!='0') ? '' : '</div>';
        $output .= ($_is_container)?'</div>':'';
    $output.='</div>';
}else{
    $output.='<div class="section-element'.$el_class.$parallax.voisen_vc_custom_css_class($css, ' ').'" '.$style.$is_parallax.'>';
        $output .= '<div class="row'.$row_sm.'">';
            $output .= wpb_js_remove_wpautop($content);
        $output .= '</div>'.$this->endBlockComment('row');
    $output.='</div>';
}
echo $output;