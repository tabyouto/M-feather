<!DOCTYPE html>
<html lang="zh-cn">
<head>
<?php
$description = '';
$keywords = '';

if (is_home() || is_page()) {
   $description = "tabyouto 关注前端,关注wordpress以及好玩的互联网的blog";

   // 将以下引号中的内容改成你的主页keywords
   $keywords = "WordPress,博客,编程,php,Tabyouto,前端";
} elseif (is_single()) {
   $description1 = get_post_meta($post->ID, "description", true);
   $description2 = preg_replace('/\s/',"",mb_strimwidth(strip_tags($post->post_content), 0, 200, "…", 'utf-8'));
   // 填写自定义字段description时显示自定义字段的内容，否则使用文章内容前200字作为描述
   $description = $description1 ? $description1 : $description2;
   
   // 填写自定义字段keywords时显示自定义字段的内容，否则使用文章tags作为关键词
   $keywords = get_post_meta($post->ID, "keywords", true);
   if($keywords == '') {
      $tags = wp_get_post_tags($post->ID);    
      foreach ($tags as $tag ) {        
         $keywords = $keywords . $tag->name . ", ";    
      }
      $keywords = rtrim($keywords, ', ');
   }
}
elseif (is_category()) {
   // 分类的description可以到后台 - 文章 -分类目录，修改分类的描述
   $description = category_description();
   $keywords = single_cat_title('', false);
}
elseif (is_tag()){
   // 标签的description可以到后台 - 文章 - 标签，修改标签的描述
   $description = tag_description();
   $keywords = single_tag_title('', false);
}
$description = trim(strip_tags($description));
$keywords = trim(strip_tags($keywords));
?>
	<meta charset="<?php bloginfo('charset') ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<meta http-equiv="Cache-Control" content="no-siteapp">
	<meta name="description" content="<?php echo $description; ?>" />
	<meta name="keywords" content="<?php echo $keywords; ?>" />
	<link rel="shortcut icon" href="<?php echo bloginfo('template_directory'); ?>/favicon.ico">
	<!--[if IE ]><script src="http://apps.bdimg.com/libs/html5shiv/r29/html5.min.js"></script><![endif]-->
	<title><?php bloginfo('name'); //echo of_get_option('connector','-'); 
	bloginfo('description'); ?></title>
	<?php wp_head(); ?>
</head>
<body>

