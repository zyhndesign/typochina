<?php
function wps_highlight_results($text){
    $sr = get_query_var('s');
    $keys = explode(" ",$sr);
    $text = preg_replace('/('.implode('|', $keys) .')/iu', '<em class="redTxt">'.$sr.'</em>', $text);//设置突出关键字样式

    return $text;
}

get_header();
?>

<section class="main">
    <section class="left">
        <form role="search" method="get" id="searchform" class="hnid_search_form" action="<?php echo home_url(); ?>">
            <input type="text" name="s" class="searchInput"  id="searchInput" value="<?php  echo get_search_query(); ?>">
        </form>
		<?php if ( have_posts() ) :
            global $wp_query;
            $search=get_search_query();
        ?>

        <p>为您搜索到<?php echo $wp_query->post_count ?>条记录</p>
        <ul class="postList">
            <?php while ( have_posts() ) : the_post();?>
                <li class="post">
                    <h2 class="postTitle"><a href="<?php the_permalink(); ?>">
                            <?php echo wps_highlight_results(get_the_title()); ?></a></h2>
                    <p class="searchExcerpt"><?php echo wps_highlight_results(get_the_excerpt()); ?></p>
                </li>
            <?php endwhile; ?>
        </ul>

        <!-- 分页-->
        <?php

        if ($total > 1) {
            if (!$current_page = get_query_var('paged')) {
                $current_page = 1;
            }
            //获取路径
            $permalink_structure = get_option('permalink_structure');
            $format = empty($permalink_structure) ? '&page=%#%' : '/page/%#%/';
            echo paginate_links(array(
                'base' => get_pagenum_link(1) . '%_%',
                'format' => $format,
                'current' => $current_page,
                'total' => $wp_query->max_page_number, 'mid_size' => 4,
                'type' => 'list'
            ));
        }
        ?>
		<?php else : ?>
            <p>没有搜索到您所需的信息！</p>
		<?php endif; ?>
    </section>
</section>

<?php get_footer(); ?>