<?php get_header();
while(have_posts()){ the_post(); $id=get_the_ID();
  $el=false; if(class_exists('\Elementor\Plugin')){ $doc=\Elementor\Plugin::$instance->documents->get($id); $el=$doc&&$doc->is_built_with_elementor(); }
  $badge=sa_dm($id,'badge','bs');
  $msgs=[]; foreach([0,1,2] as $i){ $t=$i==0?get_the_title():(sa_dm($id,'title','en')?:get_the_title()); if($i==2)$t=sa_dm($id,'title','ar')?:$t; $msgs[]=sprintf(sa_ttv('wa',$i),$t); }
  $row=function($ic,$k,$f,$cls='')use($id){ if(sa_dm($id,$f,'bs')==='')return ''; return '<div class="sa-drow"><span class="sa-dl">'.sa_ic($ic).sa_tt($k).'</span><b class="'.$cls.'">'.sa_dtr($id,$f).'</b></div>'; };
  $info=$row('nav','distance','distance').$row('clock','duration','duration').$row('car','vehicle','vehicle','sa-gold');
?>
<section class="sa-pagehero sa-dhero"><div class="sa-wrap">
  <a class="sa-dback" href="<?php echo esc_url(home_url('/turizam-bih/')); ?>"><?php echo sa_tt('back'); ?></a>
  <?php if($badge)echo '<div class="sa-dbadge sa-dbadge-static">'.sa_dtr($id,'badge').'</div>'; ?>
  <h1 class="sa-sh-title"><?php echo sa_dtitle($id); ?></h1>
</div></section>
<section class="sa-wrap sa-dsingle">
  <?php if(has_post_thumbnail())echo '<div class="sa-dhero-img">'.get_the_post_thumbnail($id,'large').'</div>'; ?>
  <div class="sa-dlayout">
    <div class="sa-dmain">
      <?php if($el){ the_content(); } else {
        $bs=apply_filters('the_content',get_post_field('post_content',$id));
        $en=apply_filters('the_content',(string)get_post_meta($id,'_sd_content_en',true));
        $ar=apply_filters('the_content',(string)get_post_meta($id,'_sd_content_ar',true));
        echo sa_tr($bs,trim($en)!==''?$en:$bs,trim($ar)!==''?$ar:(trim($en)!==''?$en:$bs),true,'div','sa-rich sa-dcontent');
      } ?>
    </div>
    <aside class="sa-dside">
      <?php if($info)echo '<div class="sa-dinfo">'.$info.'</div>'; ?>
      <a class="sa-btn sa-btn-gold sa-btn-lg sa-btn-block" <?php echo sa_wa_attrs($msgs); ?>><?php echo sa_icon('chat').sa_tt('book'); ?></a>
    </aside>
  </div>
</section>
<section class="sa-wrap sa-related"><h2 class="sa-sh-title"><?php echo sa_tt('other'); ?></h2>
<?php echo sa_render_destinations(['per_page'=>2,'paginate'=>false,'exclude'=>$id,'orderby'=>'rand']); ?></section>
<?php } get_footer(); ?>
