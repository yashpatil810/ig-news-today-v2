<?php
/**
 * Custom Walker for Mobile Navigation
 *
 * @package NewsToday
 */

class NewsToday_Mobile_Menu_Walker extends Walker_Nav_Menu {

    /**
     * Category list used inside mobile categories dropdown.
     *
     * @var array
     */
    private $menu_categories = array(
        'casino-games'         => 'Casino & Games',
        'sports-betting'       => 'Sports betting',
        'regions'              => 'Regions',
        'legal-compliance'     => 'Legal & Compliance',
        'marketing-affiliates' => 'Marketing Affiliates',
        'finance'              => 'Finance',
        'events'               => 'Events',
        'company-news'         => 'Company News',
    );

    /**
     * Starts the element output.
     *
     * @param string  $output Passed by reference. Used to append additional content.
     * @param WP_Post $item   Menu item data object.
     * @param int     $depth  Depth of menu item.
     * @param array   $args   Nav menu args.
     * @param int     $id     Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'mobile-nav-item';

        $is_categories_toggle = 0 === $depth && 'categories' === strtolower( trim( $item->title ) );

        if ( $is_categories_toggle ) {
            $classes[] = 'has-dropdown';
        }

        // Add active class for current items.
        if ( in_array( 'current-menu-item', $classes, true ) || in_array( 'current-menu-ancestor', $classes, true ) || in_array( 'current_page_parent', $classes, true ) ) {
            $classes[] = 'is-active';
        }

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $output .= '<li' . $class_names . '>';

        // Link attributes.
        $atts           = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target ) ? $item->target : '';
        $atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
        $atts['href']   = ! empty( $item->url ) ? $item->url : '';

        if ( $is_categories_toggle ) {
            $atts['href']  = '#';
            $atts['class'] = 'mobile-dropdown-toggle';
        }

        $atts       = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value      = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output  = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

        if ( $is_categories_toggle ) {
            $item_output .= '<span class="dropdown-arrow">
                <svg width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.6092 1.68966C1.00285 1.053 1.45414 0 2.33333 0H7.5H12.6667C13.5459 0 13.9971 1.053 13.3908 1.68966L8.22414 7.11466C7.83005 7.52845 7.16995 7.52845 6.77586 7.11466L1.6092 1.68966Z" fill="#FC0303"/>
                </svg>
            </span>';
        }

        $item_output .= '</a>';
        $item_output .= $args->after;

        if ( $is_categories_toggle ) {
            $item_output .= $this->render_categories_dropdown();
        }

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * Render categories dropdown list for mobile.
     *
     * @return string
     */
    private function render_categories_dropdown() {
        ob_start();
        ?>
        <div class="mobile-dropdown-menu">
            <ul class="mobile-category-list">
                <?php
                $categories = get_categories( array(
                    'hide_empty' => false,
                    'orderby'    => 'name',
                    'order'      => 'ASC',
                ) );

                if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
                    foreach ( $categories as $category ) :
                        $category_link = get_category_link( $category->term_id );
                        ?>
                        <li><a href="<?php echo esc_url( $category_link ); ?>"><?php echo esc_html( $category->name ); ?></a></li>
                        <?php
                    endforeach;
                else :
                    foreach ( $this->menu_categories as $slug => $name ) :
                        $category      = get_category_by_slug( $slug );
                        $category_link = $category ? get_category_link( $category->term_id ) : '#';
                        ?>
                        <li><a href="<?php echo esc_url( $category_link ); ?>"><?php echo esc_html( $name ); ?></a></li>
                        <?php
                    endforeach;
                endif;
                ?>
            </ul>
        </div>
        <?php
        return ob_get_clean();
    }
}

