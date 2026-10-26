<?php
if(!defined('ABSPATH'))exit;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

class SA_W_Destinations extends Widget_Base{
  public function get_name(){return 'sa_destinations';} public function get_title(){return 'SA Tourism Guides Grid';} public function get_icon(){return 'eicon-posts-grid';} public function get_categories(){return ['shams'];}
  protected function register_controls(){
    $this->start_controls_section('c',['label'=>'Query']);
    $this->add_control('per_page',['label'=>'Guides per page','type'=>Controls_Manager::NUMBER,'default'=>8]);
    $this->add_control('paginate',['label'=>'Pagination','type'=>Controls_Manager::SWITCHER,'default'=>'yes']);
    $this->add_control('orderby',['label'=>'Order by','type'=>Controls_Manager::SELECT,'default'=>'menu_order','options'=>['menu_order'=>'Manual order (Order field)','date'=>'Date (newest)','title'=>'Title','rand'=>'Random']]);
    $this->add_control('order',['label'=>'Order','type'=>Controls_Manager::SELECT,'default'=>'ASC','options'=>['ASC'=>'Ascending','DESC'=>'Descending']]);
    $this->add_responsive_control('cols',['label'=>'Columns','type'=>Controls_Manager::SELECT,'default'=>'2','tablet_default'=>'2','mobile_default'=>'1','options'=>['1'=>'1','2'=>'2','3'=>'3'],'selectors'=>['{{WRAPPER}} .sa-dgrid'=>'grid-template-columns:repeat({{VALUE}},minmax(0,1fr));']]);
    $this->end_controls_section();
    sa_style_sec($this,'s_c','Card',function($w){
      $w->add_responsive_control('gap',['label'=>'Gap','type'=>Controls_Manager::SLIDER,'range'=>['px'=>['min'=>0,'max'=>80]],'selectors'=>['{{WRAPPER}} .sa-dgrid'=>'gap:{{SIZE}}px;']]);
      $w->add_responsive_control('imgh',['label'=>'Image height','type'=>Controls_Manager::SLIDER,'range'=>['px'=>['min'=>120,'max'=>600]],'selectors'=>['{{WRAPPER}} .sa-dimg'=>'height:{{SIZE}}px;aspect-ratio:auto;']]);
      sa_style_box($w,'cb','Card','.sa-dcard'); sa_style_text($w,'ti','Title','.sa-dbody h3, .sa-dbody h3 a'); sa_style_text($w,'ex','Description','.sa-dex');
    });
    sa_style_sec($this,'s_i','Info box & badge',function($w){
      sa_style_box($w,'ib','Info box','.sa-dinfo'); sa_style_text($w,'il','Label','.sa-dl'); sa_style_text($w,'iv','Value','.sa-drow b'); sa_style_text($w,'link','Read more link','.sa-dmore');
      $w->add_control('bbg',['label'=>'Badge background','type'=>Controls_Manager::COLOR,'selectors'=>['{{WRAPPER}} .sa-dbadge'=>'background:{{VALUE}};']]);
      $w->add_control('bco',['label'=>'Badge text color','type'=>Controls_Manager::COLOR,'selectors'=>['{{WRAPPER}} .sa-dbadge'=>'color:{{VALUE}};']]);
    });
  }
  protected function render(){ $s=$this->get_settings_for_display(); echo sa_render_destinations(['per_page'=>(int)$s['per_page']?:8,'paginate'=>$s['paginate']==='yes','orderby'=>$s['orderby'],'order'=>$s['order']]); }
}

class SA_W_Tips extends Widget_Base{
  public function get_name(){return 'sa_tips';} public function get_title(){return 'SA Tips Box';} public function get_icon(){return 'eicon-info-box';} public function get_categories(){return ['shams'];}
  protected function register_controls(){
    $d=sa_tips_defaults();
    $this->start_controls_section('c',['label'=>'Content']);
    $this->add_control('icon',['label'=>'Icon','type'=>Controls_Manager::SELECT,'options'=>['compass'=>'Compass']+sa_icon_options(),'default'=>'compass']);
    sa_tri($this,'title','Title',[$d['title'],$d['title_en'],$d['title_ar']]);
    sa_tri($this,'sub','Subtitle',[$d['sub'],$d['sub_en'],$d['sub_ar']]);
    $this->add_responsive_control('cols',['label'=>'Columns','type'=>Controls_Manager::SELECT,'default'=>'2','tablet_default'=>'2','mobile_default'=>'1','options'=>['1'=>'1','2'=>'2','3'=>'3'],'selectors'=>['{{WRAPPER}} .sa-tipgrid'=>'grid-template-columns:repeat({{VALUE}},minmax(0,1fr));']]);
    $r=new Repeater(); sa_tri($r,'t','Tip title',['','','']); sa_tri($r,'d','Tip text',['','',''],true);
    $this->add_control('items',['label'=>'Tips','type'=>Controls_Manager::REPEATER,'fields'=>$r->get_controls(),'default'=>$d['items'],'title_field'=>'{{{ t }}}']);
    $this->end_controls_section();
    sa_style_sec($this,'s','Style',function($w){
      sa_style_box($w,'bx','Outer box','.sa-tips'); sa_style_text($w,'ti','Title','.sa-tips-h h2'); sa_style_text($w,'su','Subtitle','.sa-tips-h small');
      sa_style_box($w,'tc','Tip card','.sa-tip'); sa_style_text($w,'tt','Tip title','.sa-tip h4'); sa_style_text($w,'td','Tip text','.sa-tip p');
      $w->add_control('ibg',['label'=>'Icon box background','type'=>Controls_Manager::COLOR,'selectors'=>['{{WRAPPER}} .sa-tips-ico'=>'background:{{VALUE}};']]);
      $w->add_control('ico',['label'=>'Icon color','type'=>Controls_Manager::COLOR,'selectors'=>['{{WRAPPER}} .sa-tips-ico'=>'color:{{VALUE}};']]);
    });
  }
  protected function render(){
    $s=$this->get_settings_for_display();
    echo '<div class="sa-tips"><div class="sa-tips-h"><span class="sa-tips-ico">'.sa_ic($s['icon']).'</span><div><h2>'.sa_t3($s,'title').'</h2><small>'.sa_t3($s,'sub').'</small></div></div><div class="sa-tipgrid">';
    foreach($s['items'] as $it) echo '<div class="sa-tip"><h4>'.sa_t3($it,'t').'</h4><p>'.sa_t3($it,'d',true).'</p></div>';
    echo '</div></div>';
  }
}
