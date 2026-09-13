<?php
/**
 * Custom Walker for Primary Navigation with Mega Menu support
 *
 * @package NewsToday
 */

class NewsToday_Mega_Menu_Walker extends Walker_Nav_Menu {

    /**
     * Category list used inside mega menu (static list as per design).
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
     * @param string $output Passed by reference. Used to append additional content.
     * @param WP_Post $item  Menu item data object.
     * @param int    $depth  Depth of menu item.
     * @param array  $args   Nav menu args.
     * @param int    $id     Current item ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $classes      = empty( $item->classes ) ? array() : (array) $item->classes;
        $is_mega_menu = in_array( 'mega-menu-trigger', $classes, true );

        // Build class list.
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        if ( $is_mega_menu ) {
            $class_names .= ' has-mega-dropdown';
        }
        $class_names = $class_names ? ' class="nav-item ' . esc_attr( $class_names ) . '"' : ' class="nav-item"';

        $output .= '<li' . $class_names . '>';

        // Link attributes.
        $atts           = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target ) ? $item->target : '';
        $atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
        $atts['href']   = ! empty( $item->url ) ? $item->url : '';

        if ( $is_mega_menu ) {
            $atts['class'] = 'dropdown-toggle';
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

        // Dropdown arrow for mega menu trigger.
        if ( $is_mega_menu ) {
            $item_output .= '<span class="dropdown-arrow">
                <svg width="15" height="8" viewBox="0 0 15 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.6092 1.68966C1.00285 1.053 1.45414 0 2.33333 0H7.5H12.6667C13.5459 0 13.9971 1.053 13.3908 1.68966L8.22414 7.11466C7.83005 7.52845 7.16995 7.52845 6.77586 7.11466L1.6092 1.68966Z" fill="#FC0303"/>
                </svg>
            </span>';
        }

        $item_output .= '</a>';
        $item_output .= $args->after;

        // Inject mega menu markup if needed.
        if ( $is_mega_menu ) {
            $item_output .= $this->render_mega_menu();
        }

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * Render the mega menu markup (static categories + dynamic posts grid placeholder).
     *
     * @return string
     */
    private function render_mega_menu() {
        ob_start();
        ?>
        <div class="mega-dropdown-menu">
            <div class="mega-dropdown-inner">
                <!-- Left Sidebar - Categories -->
                <div class="mega-dropdown-sidebar">
                    <ul class="category-list">
                        <?php
                        $categories = get_categories( array(
                            'hide_empty' => false,
                            'orderby'    => 'name',
                            'order'      => 'ASC',
                        ) );

                        $first = true;
                        if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) :
                            foreach ( $categories as $category ) :
                                $slug           = $category->slug;
                                $name           = $category->name;
                                $category_link  = get_category_link( $category->term_id );
                                $category_color = newstoday_get_category_color( $category );
                                ?>
                                <li
                                    class="category-item<?php echo $first ? ' is-active' : ''; ?>"
                                    data-category="<?php echo esc_attr( $slug ); ?>"
                                    data-color="<?php echo esc_attr( $category_color ); ?>"
                                    style="--category-color: <?php echo esc_attr( $category_color ); ?>;"
                                >
                                    <a href="<?php echo esc_url( $category_link ); ?>"><?php echo esc_html( $name ); ?></a>
                                </li>
                                <?php
                                $first = false;
                            endforeach;
                        else :
                            foreach ( $this->menu_categories as $slug => $name ) :
                                $category      = get_category_by_slug( $slug );
                                $category_link = $category ? get_category_link( $category->term_id ) : '#';
                                $category_color = $category ? newstoday_get_category_color( $category ) : '#606060';
                                ?>
                                <li
                                    class="category-item<?php echo $first ? ' is-active' : ''; ?>"
                                    data-category="<?php echo esc_attr( $slug ); ?>"
                                    data-color="<?php echo esc_attr( $category_color ); ?>"
                                    style="--category-color: <?php echo esc_attr( $category_color ); ?>;"
                                >
                                    <a href="<?php echo esc_url( $category_link ); ?>"><?php echo esc_html( $name ); ?></a>
                                </li>
                                <?php
                                $first = false;
                            endforeach;
                        endif;
                        ?>
                    </ul>
                </div>
                <!-- Vertical Divider -->
                <div class="mega-dropdown-divider"></div>
                <!-- Right Side - Posts Grid -->
                <div class="mega-dropdown-posts">
                    <div class="posts-grid" id="mega-dropdown-posts-grid">
                        <div class="posts-loading">
                            <p><?php esc_html_e( 'Loading posts...', 'newstoday' ); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

