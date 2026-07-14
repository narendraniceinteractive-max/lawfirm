<?php
/**
 * Defines the custom field type class.
 */
if (!defined('ABSPATH')) {
    exit;
}

function get_menu_nav_objects() {
    $fieldSelectOptions = [];
    $fieldMenu = wp_get_nav_menus();

    foreach ($fieldMenu as $fieldInfo) {
        $fieldSelectOptions[] = [
            'name' => $fieldInfo->name,
            'id' => $fieldInfo->term_id,
            'slug' => $fieldInfo->slug,
        ];
    }

    return $fieldSelectOptions;
}

/**
 * sidebar_acf_field_nav_menu_select_field class.
 */
class sidebar_acf_field_nav_menu_select_field extends \acf_field {

    /**
     * Controls field type visibilty in REST requests.
     *
     * @var bool
     */
    public $show_in_rest = true;

    /**
     * Environment values relating to the theme or plugin.
     *
     * @var array $env Plugin or theme context such as 'url' and 'version'.
     */
    private $env;

    /**
     * Constructor.
     */
    public function __construct() {
        /**
         * Field type reference used in PHP and JS code.
         *
         * No spaces. Underscores allowed.
         */
        $this->name = 'nav_menu_select_field';

        /**
         * Field type label.
         *
         * For public-facing UI. May contain spaces.
         */
        $this->label = __('Nav Menu Select Field', 'nav-menu-select-field');

        /**
         * The category the field appears within in the field type picker.
         */
        $this->category = 'basic'; // basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME

        /**
         * Field type Description.
         *
         * For field descriptions. May contain spaces.
         */
        $this->description = __('Use this field to select what Nav Menu you want to use as a sidebar for location pages', 'nav-menu-select-field');

        /**
         * Field type Doc URL.
         *
         * For linking to a documentation page. Displayed in the field picker modal.
         */
        $this->doc_url = 'coming-soon';

        /**
         * Field type Tutorial URL.
         *
         * For linking to a tutorial resource. Displayed in the field picker modal.
         */
        $this->tutorial_url = 'coming-soon-field';

        /**
         * Defaults for your custom user-facing settings for this field type.
         * 
         */
        /**
         * Strings used in JavaScript code.
         *
         * Allows JS strings to be translated in PHP and loaded in JS via:
         *
         * ```js
         * const errorMessage = acf._e("nav_menu_select_field", "error");
         * ```
         */
        $this->l10n = array(
            'error' => __('Error! Please create a Menu to use', 'nav-menu-select-field'),
        );

        $this->env = array(
            'url' => site_url(str_replace(ABSPATH, '', __DIR__)), // URL to the acf-nav-menu-select-field directory.
            'version' => '1.0', // Replace this with your theme or plugin version constant.
        );

        /**
         * Field type preview image.
         *
         * A preview image for the field type in the picker modal.
         */
        //$this->preview_image = $this->env['url'] . '/assets/images/field-preview-custom.png';

        parent::__construct();
    }

    /**
     * Settings to display when users configure a field of this type.
     *
     * These settings appear on the ACF “Edit Field Group�? admin page when
     * setting up the field.
     *
     * @param array $field
     * @return void
     */
    public function render_field_settings($field) {
        /*
         * Repeat for each setting you wish to display for this field type.
         */

        $fieldSelectOptions = get_menu_nav_objects();
        $fieldSelectCreateArray = [];

        foreach ($fieldSelectOptions as $value) {

            $fieldSelectCreateArray[$value['id']] = __($value['name'], 'acf');
        }

        if (empty($fieldSelectCreateArray)) {
            $fieldSelectCreateArray['AB00'] = __('YOU NEED TO CREATE A MENU FIRST', 'acf');
        }

        acf_render_field_setting(
                $field,
                array(
                    'label' => __('Select Menu', 'nav-menu-select-field'),
                    'instructions' => __('Select which menu want to use as the default.', 'nav-menu-select-field'),
                    'type' => 'select',
                    'name' => 'nav_menu_sidebar',
                    'choices' => $fieldSelectCreateArray,
                )
                //above creates an input using those keys.   will only show on acf field set up side
        );

        // To render field settings on other tabs in ACF 6.0+:
        // https://www.advancedcustomfields.com/resources/adding-custom-settings-fields/#moving-field-setting
    }

    /**
     * HTML content to show when a publisher edits the field on the edit screen.
     *
     * @param array $field The field settings and values.
     * @return void
     */
    public function render_field($field) {
        // Debug output to show what field data is available.
        /* echo '<pre>';
          print_r( $field );
          echo '</pre>'; */

        // Display an input field that uses the 'font_size' setting.
        //new custome code see if this works
        $fieldSelectOptions = [];
        $fieldMenu = wp_get_nav_menus();

        foreach ($fieldMenu as $fieldInfo) {
            $fieldSelectOptions[] = [
                'name' => $fieldInfo->name,
                'id' => $fieldInfo->term_id,
                'slug' => $fieldInfo->slug,
            ];
        }

        $fieldSelectCreate = "";

        if (!empty($fieldSelectOptions)) {
            $fieldSelectCreate .= '<option value="" >Default Menu - Select Other Options to Change</option>';
        } else {
            $fieldSelectCreate .= '<option value="AB00" >YOU NEED TO CREATE A MENU FIRST</option>';
        }

        /* $fieldSelectCreate .= */
        foreach ($fieldSelectOptions as $value) {

            if ($field['value'] != $value['id']) {
                $fieldSelectCreate .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
            } else {
                $fieldSelectCreate .= '<option selected value="' . $value['id'] . '">' . $value['name'] . '</option>';
            }
        }
        ?>



        <select name="<?php echo esc_attr($field['name']) ?>"> 
            <?php echo $fieldSelectCreate; ?>              
        </select>

        <?php
    }

    /**
     * Enqueues CSS and JavaScript needed by HTML in the render_field() method.
     *
     * Callback for admin_enqueue_script.
     *
     * @return void
     */
    public function input_admin_enqueue_scripts() {
        /* $url     = trailingslashit( get_stylesheet_directory_uri());
          $version = $this->env['version'];

          wp_register_script(
          'sidebar-nav-menu-select-field',
          "{$url}acf-nav-menu-select-field/assets/js/field.js",
          array( 'acf-input' ),
          $version
          );

          wp_register_style(
          'sidebar-nav-menu-select-field',
          "{$url}acf-nav-menu-select-field/assets/css/field.css",
          array( 'acf-input' ),
          $version
          );

          wp_enqueue_script( 'sidebar-nav-menu-select-field' );
          wp_enqueue_style( 'sidebar-nav-menu-select-field' ); */
    }

}
