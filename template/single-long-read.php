<div class="govuk-grid-row">
    <div class="govuk-grid-column-two-thirds">
        <article>
            <header>
                <h1><?php the_title(); ?></h1>
            </header>

            <div class="entry content rich-text">
                <?php the_content(); ?>
            </div>

        </article>
    </div>
    <div class="govuk-grid-column-one-third">
        <div class="long-read-navigation__container">
            <nav class="long-read-navigation">
                <h2>Chapter navigation</h2>
                <?php $items = LongReadPlugin\Navigation::getItems();
                    echo "<ul class='long-read-navigation__items'>";
                    foreach ($items as $item) {
                        if ($item->url) {
                            printf("<li class='long-read-navigation__item'><a href='%s'>%s</a></li>", esc_url($item->url), wp_kses_post($item->title));
                        } else {
                            printf("<li class='long-read-navigation__item long-read-navigation__current-item'>%s</li>", wp_kses_post($item->title));
                            echo "<ul>";
                            foreach ($item->subItems as $subItem) {
                                printf("<li class='long-read-navigation__in-page-item'><a href='#%s'>%s</a></li>", esc_attr($subItem->id), wp_kses_post($subItem->title));
                            }
                            echo "</ul>";
                        }
                    }
                    echo "</ul>";
                ?>
            </nav>
        </div>
    </div>
</div> 
