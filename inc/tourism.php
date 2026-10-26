<?php
if(!defined('ABSPATH'))exit;

/* ---------- Post type: Turizam BiH guides ---------- */
add_action('init',function(){
  register_post_type('destination',[
    'labels'=>['name'=>'Turizam BiH','singular_name'=>'Guide','add_new'=>'Add Guide','add_new_item'=>'Add New Guide','edit_item'=>'Edit Guide','all_items'=>'All Guides','menu_name'=>'Turizam BiH'],
    'public'=>true,'has_archive'=>false,'rewrite'=>['slug'=>'turizam-bih','with_front'=>false],
    'menu_icon'=>'dashicons-location-alt','menu_position'=>6,
    'supports'=>['title','editor','thumbnail','page-attributes','revisions'],'show_in_rest'=>false,
  ]);
  if(get_option('sa_tour_flush')){ delete_option('sa_tour_flush'); flush_rewrite_rules(); }
},21);

add_action('wp_enqueue_scripts',function(){ wp_enqueue_style('sa-tourism',SA_URI.'/assets/tourism.css',['sa-main'],SA_VER); },20);

/* ---------- Local strings + icons ---------- */
function sa_tt($k,$tag='span'){
  static $d=null; if($d===null)$d=[
    'distance'=>['Udaljenost:','Distance:','المسافة:'],
    'duration'=>['Trajanje:','Duration:','المدة:'],
    'vehicle'=>['Vozilo:','Vehicle:','المركبة:'],
    'read'=>['Pročitaj kompletan vodič','Read the full guide','اقرأ الدليل كاملاً'],
    'back'=>['Nazad na Turizam BiH','Back to Tourism BiH','العودة إلى السياحة في البوسنة'],
    'book'=>['Rezerviši vozilo za ovaj izlet','Book a vehicle for this trip','احجز مركبة لهذه الرحلة'],
    'other'=>['Još vodiča','More guides','المزيد من الأدلة'],
    'wa'=>['Zdravo, zanima me vozilo za izlet: %s','Hello, I am interested in a vehicle for the trip: %s','مرحبًا، أنا مهتم بمركبة للرحلة: %s'],
    'none'=>['Uskoro novi vodiči.','New guides coming soon.','أدلة جديدة قريبًا.'],
  ];
  return sa_tr($d[$k][0],$d[$k][1],$d[$k][2],false,$tag);
}
function sa_ttv($k,$i){ $x=['wa'=>['Zdravo, zanima me vozilo za izlet: %s','Hello, I am interested in a vehicle for the trip: %s','مرحبًا، أنا مهتم بمركبة للرحلة: %s']]; return $x[$k][$i]; }
function sa_ic($n){
  $p=['nav'=>'<polygon points="3 11 22 2 13 21 11 13 3 11"/>','compass'=>'<circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>','chev'=>'<path d="m9 18 6-6-6-6"/>'];
  if(!isset($p[$n]))return sa_icon($n);
  return '<svg class="sa-i" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.$p[$n].'</svg>';
}

/* ---------- Meta ---------- */
function sa_dfields(){return ['title'=>'Title','badge'=>'Region badge (on image)','distance'=>'Distance','duration'=>'Duration','vehicle'=>'Recommended vehicle','excerpt'=>'Short description (card)'];}
function sa_dm($id,$f,$l){ return (string)get_post_meta($id,'_sd_'.$f.'_'.$l,true); }
function sa_dtr($id,$f){ return sa_tr(sa_dm($id,$f,'bs'),sa_dm($id,$f,'en'),sa_dm($id,$f,'ar')); }
function sa_dtitle($id){ return sa_tr(get_the_title($id),sa_dm($id,'title','en'),sa_dm($id,'title','ar')); }
function sa_dexcerpt($id){
  $bs=sa_dm($id,'excerpt','bs'); if($bs==='')$bs=wp_trim_words(wp_strip_all_tags(get_post_field('post_content',$id)),30);
  return sa_tr($bs,sa_dm($id,'excerpt','en'),sa_dm($id,'excerpt','ar'));
}

add_action('add_meta_boxes',function(){ add_meta_box('sa_dest','Guide details (Bosanski / English / العربية)','sa_dest_box','destination','normal','high'); });
function sa_dest_box($post){
  wp_nonce_field('sa_dest','sa_dnonce');
  echo '<p class="description">Bosnian title = the title field above, Bosnian full text = the main editor. Fill English and Arabic here; empty fields fall back to Bosnian. Set the card/hero photo with “Featured image”.</p>';
  echo '<table class="widefat striped"><thead><tr><th></th><th>Bosanski</th><th>English</th><th>العربية</th></tr></thead><tbody>';
  foreach(sa_dfields() as $f=>$label){
    echo '<tr><th>'.esc_html($label).'</th>';
    foreach(['bs','en','ar'] as $l){
      $v=esc_attr(sa_dm($post->ID,$f,$l)); $dir=$l==='ar'?' dir="rtl"':'';
      if($f==='title'&&$l==='bs'){ echo '<td><em>(title field above)</em></td>'; continue; }
      if($f==='excerpt') echo '<td><textarea class="widefat" rows="4"'.$dir.' name="sd['.$f.']['.$l.']">'.esc_textarea(sa_dm($post->ID,$f,$l)).'</textarea></td>';
      else echo '<td><input class="widefat" type="text"'.$dir.' name="sd['.$f.']['.$l.']" value="'.$v.'"></td>';
    }
    echo '</tr>';
  }
  echo '</tbody></table>';
  foreach(['en'=>'Full guide text – English','ar'=>'Full guide text – العربية'] as $l=>$t){
    echo '<h4 style="margin:18px 0 6px">'.esc_html($t).'</h4>';
    wp_editor(get_post_meta($post->ID,'_sd_content_'.$l,true),'sd_content_'.$l,['textarea_name'=>'sd_content_'.$l,'textarea_rows'=>10,'media_buttons'=>true]);
  }
}
add_action('save_post_destination',function($id){
  if(!isset($_POST['sa_dnonce'])||!wp_verify_nonce($_POST['sa_dnonce'],'sa_dest')||!current_user_can('edit_post',$id)||(defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE))return;
  $sd=wp_unslash($_POST['sd']??[]);
  foreach(sa_dfields() as $f=>$_) foreach(['bs','en','ar'] as $l){
    if(!isset($sd[$f][$l]))continue;
    update_post_meta($id,'_sd_'.$f.'_'.$l,$f==='excerpt'?sanitize_textarea_field($sd[$f][$l]):sanitize_text_field($sd[$f][$l]));
  }
  foreach(['en','ar'] as $l) if(isset($_POST['sd_content_'.$l])) update_post_meta($id,'_sd_content_'.$l,wp_kses_post(wp_unslash($_POST['sd_content_'.$l])));
});
add_filter('manage_destination_posts_columns',function($c){ return ['cb'=>$c['cb'],'sd_thumb'=>'Photo','title'=>'Guide','sd_badge'=>'Region','date'=>$c['date']]; });
add_action('manage_destination_posts_custom_column',function($c,$id){
  if($c==='sd_thumb')echo get_the_post_thumbnail($id,[70,45]);
  if($c==='sd_badge')echo esc_html(sa_dm($id,'badge','bs'));
},10,2);
add_action('admin_init',function(){
  $s=get_option('elementor_cpt_support',['post','page']);
  if(is_array($s)&&!in_array('destination',$s)){ $s[]='destination'; update_option('elementor_cpt_support',$s); }
});

/* ---------- Card + grid ---------- */
function sa_dest_card($id){
  $img=has_post_thumbnail($id)?get_the_post_thumbnail($id,'sa-card',['loading'=>'lazy']):'<div class="sa-noimg">'.sa_icon('map').'</div>';
  $link=esc_url(get_permalink($id)); $badge=sa_dm($id,'badge','bs');
  $row=function($ic,$k,$f,$cls='')use($id){ if(sa_dm($id,$f,'bs')===''&&sa_dm($id,$f,'en')==='')return ''; return '<div class="sa-drow"><span class="sa-dl">'.sa_ic($ic).sa_tt($k).'</span><b class="'.$cls.'">'.sa_dtr($id,$f).'</b></div>'; };
  $info=$row('nav','distance','distance').$row('clock','duration','duration').$row('car','vehicle','vehicle','sa-gold');
  ob_start(); ?>
  <article class="sa-dcard">
    <a class="sa-dimg" href="<?php echo $link; ?>"><?php echo $img; if($badge)echo '<span class="sa-dbadge">'.sa_dtr($id,'badge').'</span>'; ?></a>
    <div class="sa-dbody">
      <h3><a href="<?php echo $link; ?>"><?php echo sa_dtitle($id); ?></a></h3>
      <p class="sa-dex"><?php echo sa_dexcerpt($id); ?></p>
      <?php if($info)echo '<div class="sa-dinfo">'.$info.'</div>'; ?>
      <a class="sa-dmore" href="<?php echo $link; ?>"><?php echo sa_tt('read'); ?><?php echo sa_ic('chev'); ?></a>
    </div>
  </article>
  <?php return ob_get_clean();
}
function sa_render_destinations($a=[]){
  $a=wp_parse_args($a,['per_page'=>8,'orderby'=>'menu_order','order'=>'ASC','exclude'=>0,'paginate'=>true]);
  $paged=max(1,(int)($_GET['tp']??1));
  $q=new WP_Query(['post_type'=>'destination','post_status'=>'publish','posts_per_page'=>(int)$a['per_page'],'paged'=>$a['paginate']?$paged:1,'orderby'=>$a['orderby'],'order'=>$a['order'],'post__not_in'=>$a['exclude']?[(int)$a['exclude']]:[]]);
  ob_start();
  echo '<div class="sa-dwrap"><div class="sa-dgrid">';
  if($q->have_posts()){ while($q->have_posts()){ $q->the_post(); echo sa_dest_card(get_the_ID()); } } else echo '<p class="sa-noresults">'.sa_tt('none').'</p>';
  echo '</div>';
  if($a['paginate']&&$q->max_num_pages>1){
    $base=(is_ssl()?'https://':'http://').($_SERVER['HTTP_HOST']??'').strtok($_SERVER['REQUEST_URI']??'/','?');
    echo '<nav class="sa-dpag">'.paginate_links(['base'=>esc_url_raw($base).'%_%','format'=>'?tp=%#%','current'=>$paged,'total'=>$q->max_num_pages,'prev_text'=>'‹','next_text'=>'›']).'</nav>';
  }
  echo '</div>'; wp_reset_postdata();
  return ob_get_clean();
}
add_shortcode('sa_destinations',function($atts){ return sa_render_destinations(shortcode_atts(['per_page'=>8],$atts)); });

/* ---------- Elementor widgets ---------- */
add_action('elementor/widgets/register',function($wm){
  require_once SA_DIR.'/inc/widgets.php';
  require_once SA_DIR.'/inc/tourism-widgets.php';
  $wm->register(new SA_W_Destinations()); $wm->register(new SA_W_Tips());
},20);

/* ---------- One-time setup: demo guides + "Turizam BiH" page ---------- */
add_action('admin_init',function(){
  if(get_option('sa_tour_done')||!current_user_can('manage_options')||!post_type_exists('destination'))return;
  if(!function_exists('sa_container')||!function_exists('sa_widget_defaults')){ require_once SA_DIR.'/inc/widgets.php'; }
  sa_tour_install(); update_option('sa_tour_done',1); update_option('sa_tour_flush',1);
},40);

function sa_tour_install(){
  if(!get_posts(['post_type'=>'destination','numberposts'=>1,'post_status'=>'any'])){
    $g=[
     ['Sarajevo Stari Grad i Trebević','Sarajevo Old Town and Trebević','سراييفو البلدة القديمة وجبل تريبيفيتش','Kanton Sarajevo','Sarajevo Canton','كانتون سراييفو',
      'Uronite u osmanski šarm Baščaršije, kušajte autentičnu bosansku kafu i ćevape, i odvezite se na planinu Trebević za predivne panoramske poglede.','Immerse yourself in the Ottoman charm of Baščaršija, taste authentic Bosnian coffee and ćevapi, and drive up Mount Trebević for stunning panoramic views.','انغمس في سحر باشتشارشيا العثماني، وتذوّق القهوة البوسنية الأصيلة والتشيفابي، واصعد بالسيارة إلى جبل تريبيفيتش للاستمتاع بإطلالات بانورامية خلابة.',
      'Lokalno (0 - 10 km)','Local (0 - 10 km)','محلي (0 - 10 كم)','Cijeli dan / Pola dana','Full day / Half day','يوم كامل / نصف يوم','Limuzina ili kompakt (Golf 8 / Škoda)','Sedan or compact (Golf 8 / Škoda)','سيدان أو سيارة صغيرة (جولف 8 / سكودا)'],
     ['Mostar, Blagaj Tekija i Vodopad Kravice','Mostar, Blagaj Tekke and Kravice Waterfall','موستار وتكية بلاغاي وشلال كرافيتسه','Hercegovina','Herzegovina','الهرسك',
      'Svjetski poznato putovanje kroz kanjon rijeke Neretve do UNESCO Starog mosta u Mostaru, mistične 600 godina stare Blagaj Tekije i smaragdnih kaskada vodopada Kravice.','A world-famous journey through the Neretva river canyon to the UNESCO-listed Old Bridge in Mostar, the mystical 600-year-old Blagaj Tekke and the emerald cascades of Kravice waterfall.','رحلة مشهورة عالميًا عبر وادي نهر نيريتفا إلى الجسر القديم في موستار المدرج في اليونسكو، وتكية بلاغاي التي يبلغ عمرها 600 عام، وشلالات كرافيتسه الزمردية.',
      '125 km (cca 2h vožnje magistralom i autoputem)','125 km (approx. 2h drive via main road and motorway)','125 كم (حوالي ساعتين بالسيارة)','1 - 2 Dana','1 - 2 Days','1 - 2 يوم','Luksuzni SUV ili Mercedes E-Klasa','Luxury SUV or Mercedes E-Class','سيارة دفع رباعي فاخرة أو مرسيدس الفئة E'],
     ['Olimpijske planine: Bjelašnica i Jahorina','Olympic Mountains: Bjelašnica and Jahorina','الجبال الأولمبية: بيلاشنيتسا ويهورينا','Sarajevska visoravan','Sarajevo Plateau','هضبة سراييفو',
      'Svjež planinski zrak, alpske brvnare, borove šume i aktivnosti na otvorenom. Ljeti uživajte u vožnji kvadova, planinarenju i ugodnoj temperaturi; zimi u vrhunskim ski stazama.','Fresh mountain air, alpine cabins, pine forests and outdoor activities. Enjoy quad rides, hiking and pleasant temperatures in summer, and top-class ski slopes in winter.','هواء جبلي منعش وأكواخ ألبية وغابات صنوبر وأنشطة في الهواء الطلق. استمتع صيفًا بقيادة الدراجات الرباعية والمشي، وشتاءً بمنحدرات التزلج الرائعة.',
      '32 km (cca 40 min)','32 km (approx. 40 min)','32 كم (حوالي 40 دقيقة)','Pola dana do cijeli dan','Half day to full day','نصف يوم إلى يوم كامل','Range Rover Sport 4x4 ili Tiguan R-Line','Range Rover Sport 4x4 or Tiguan R-Line','رانج روفر سبورت 4x4 أو تيجوان R-Line'],
     ['Jajce, Plivska jezera i historijski Travnik','Jajce, Pliva Lakes and historic Travnik','يايتسه وبحيرات بليفا وتراونيك التاريخية','Srednja Bosna','Central Bosnia','وسط البوسنة',
      'Posjetite Travnik–grad osmanskih vezira–sa srednjovjekovnom tvrđavom i izvorom Plava Voda. Zatim nastavite do Jajca, jedinstvenog po veličanstvenom vodopadu od 22m u samom centru i mlinčićima na vodi.','Visit Travnik, the city of Ottoman viziers, with its medieval fortress and the Plava Voda spring. Then continue to Jajce, unique for its majestic 22m waterfall in the very centre and the water mills.','زر ترافنيك مدينة الوزراء العثمانيين بقلعتها من القرون الوسطى وينبوع بلافا فودا. ثم تابع إلى يايتسه الفريدة بشلالها المهيب بارتفاع 22 مترًا في قلب المدينة وطواحين المياه.',
      '150 km (cca 2h 30m)','150 km (approx. 2h 30m)','150 كم (حوالي ساعتين ونصف)','Cjelodnevni izlet','Full-day trip','رحلة ليوم كامل','Mercedes V-Klasa (Porodica) ili Škoda Superb','Mercedes V-Class (Family) or Škoda Superb','مرسيدس الفئة V (عائلات) أو سكودا سوبيرب'],
    ];
    $o=0;
    foreach($g as $x){ $o++;
      $id=wp_insert_post(['post_type'=>'destination','post_status'=>'publish','post_title'=>$x[0],'menu_order'=>$o,'post_content'=>'<p>'.$x[9].'</p>']);
      if(!$id||is_wp_error($id))continue;
      $m=['title'=>[$x[0],$x[1],$x[2]],'badge'=>[$x[3],$x[4],$x[5]],'excerpt'=>[$x[6],$x[7],$x[8]],'distance'=>[$x[9],$x[10],$x[11]],'duration'=>[$x[12],$x[13],$x[14]],'vehicle'=>[$x[15],$x[16],$x[17]]];
      foreach($m as $f=>$v) foreach(['bs','en','ar'] as $i=>$l) update_post_meta($id,'_sd_'.$f.'_'.$l,$v[$i]);
      update_post_meta($id,'_sd_content_en','<p>'.$x[7].'</p>'); update_post_meta($id,'_sd_content_ar','<p>'.$x[8].'</p>');
      wp_update_post(['ID'=>$id,'post_content'=>'<p>'.$x[6].'</p>']);
    }
  }
  $head=['eyebrow'=>'TURISTIČKI BLOG & VODIČ KROZ BIH','eyebrow_en'=>'TOURISM BLOG & GUIDE TO BIH','eyebrow_ar'=>'مدونة سياحية ودليل البوسنة','title'=>'Otkrijte Čuda Bosne i Hercegovine','title_en'=>'Discover the Wonders of Bosnia and Herzegovina','title_ar'=>'اكتشف عجائب البوسنة والهرسك','sub'=>'Od smaragdnih kanjona i vodopada do drevnih osmanskih čaršija i planinskih vrhova.','sub_en'=>'From emerald canyons and waterfalls to ancient Ottoman bazaars and mountain peaks.','sub_ar'=>'من الأخاديد الزمردية والشلالات إلى الأسواق العثمانية العريقة والقمم الجبلية.','tag'=>'h1'];
  $tips=sa_tips_defaults(); foreach($tips['items'] as &$t)$t['_id']=sa_eid();
  $data=[
    sa_container([sa_wid('sa_heading',$head)],[70,24,10,24],'#0e0c0b'),
    sa_container([sa_wid('sa_destinations',['per_page'=>8,'orderby'=>'menu_order','order'=>'ASC','paginate'=>'yes'])],[30,24,40,24],'#0e0c0b'),
    sa_container([sa_wid('sa_tips',$tips)],[20,24,100,24],'#0e0c0b'),
  ];
  $page=get_page_by_path('turizam-bih');
  if($page&&get_post_meta($page->ID,'_elementor_data',true))return;
  $pid=$page?$page->ID:wp_insert_post(['post_type'=>'page','post_status'=>'publish','post_title'=>'Turizam BiH','post_name'=>'turizam-bih','post_content'=>'']);
  if($pid&&!is_wp_error($pid)){
    update_post_meta($pid,'_elementor_edit_mode','builder'); update_post_meta($pid,'_elementor_template_type','wp-page');
    update_post_meta($pid,'_elementor_version',defined('ELEMENTOR_VERSION')?ELEMENTOR_VERSION:'3.20.0');
    update_post_meta($pid,'_elementor_data',wp_slash(wp_json_encode($data)));
  }
}
function sa_tips_defaults(){return [
  'icon'=>'compass',
  'title'=>'Korisni Savjeti za Vožnju u BiH','title_en'=>'Useful Driving Tips for BiH','title_ar'=>'نصائح مفيدة للقيادة في البوسنة',
  'sub'=>'Essential rules for seamless journeys across Bosnia and Herzegovina','sub_en'=>'Essential rules for seamless journeys across Bosnia and Herzegovina','sub_ar'=>'قواعد أساسية لرحلات سلسة عبر البوسنة والهرسك',
  'items'=>[
    ['t'=>'Pravila i Ograničenja Brzine','t_en'=>'Rules and Speed Limits','t_ar'=>'القواعد وحدود السرعة','d'=>'Brzina u naselju je 50 km/h, van naselja 80 km/h, a na autoputu 130 km/h. Svjetla moraju biti upaljena danju i noću.','d_en'=>'The speed limit is 50 km/h in towns, 80 km/h outside towns and 130 km/h on motorways. Headlights must be on day and night.','d_ar'=>'حد السرعة 50 كم/س داخل المدن و80 كم/س خارجها و130 كم/س على الطريق السريع. يجب إبقاء الأضواء مضاءة ليلًا ونهارًا.'],
    ['t'=>'Planinski i Panoramski Putevi','t_en'=>'Mountain and Scenic Roads','t_ar'=>'الطرق الجبلية والبانورامية','d'=>'BiH nudi predivne rute (npr. kanjon Sarajevo - Mostar). Preporučujemo SUV modele za opuštenu vožnju planinama.','d_en'=>'BiH offers beautiful routes (e.g. the Sarajevo - Mostar canyon). We recommend SUV models for relaxed mountain driving.','d_ar'=>'تقدم البوسنة طرقًا رائعة (مثل وادي سراييفو - موستار). نوصي بسيارات الدفع الرباعي لقيادة مريحة في الجبال.'],
  ]];}
