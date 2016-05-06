<?php
/*
Template Name: Quote Template
*/
?>

<!-- BEGIN FRONT PAGE TRENDING SECTION -->

<?php
    echo do_shortcode('[ldf_products]');

    echo do_shortcode('[ldf_products_table]');
?>

<!-- END FRONT PAGE TRENDING SECTION -->
<!-- BEGIN FRONT PAGE ALL ABOUT YOU SECTION -->
<div class="fp-aboutyou row">
<div class="content fp-aboutyou-content column small-12">
    <?php
        $my_postid_aay_content = 30; //This is page id or post id
        $content_post = get_post($my_postid_aay_content);
        $content = $content_post->post_content;
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]>', $content);
        echo $content;
    ?>
    
   <form class="fp-aboutyou-form">
    <p>My name is <input type="text" placeholder="John or Jane Doe" />.</p>
        
            <p><label for="iam">I am</label>
                <select name="iam">
                    <option>buying a house</option>
                    <option>refinancing my house</option>
                </select>
            .</p>
            
            <p>I want to
            <select>
                <option>lower my payment</option>
                    <option>get the lowest rate</option>
                    <option>get the lowest closing cost</option>
                    <option>get the lowest total loan cost</option>
                </select>
            .</p>
            
            <p>The home I want is in <input type="text" placeholder="area code" />, and costs $<input type="text" placeholder="200,000" />.</p>
            
            <p>I have a downpayment of $<input type="text" placeholder="40,000" />, (that's <input type="text" placeholder="20" />%).</p>
            
            <p>My credit is 
            <select>
                <option>excellent (720+)</option>
                    <option>good (690-719)</option>
                    <option>average (630-689)</option>
                    <option>poor (300-629)</option>
                </select>.
            </p>
        </form>
    
<p class="center"><a class="button blue">Show Me Some Options</a></p>
        
    </div>
</div>
<!-- END FRONT PAGE ALL ABOUT YOU SECTION -->