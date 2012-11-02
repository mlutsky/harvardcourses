<!doctype html>
<html>
    <head>
    	<title>HarvardCourses</title>
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" />
        <script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script>
        <? $this->load->helper('url'); ?>
    <script src="<? echo base_url();?>default.js"></script>
    <link rel="stylesheet" href="<? echo base_url();?>courses.css" />
</head>
<body>
    <?php if($back == 'search'): ?>
        <div data-role="page" id="<?= $page ?>" data-add-back-btn="false">
    <?php else: ?>
        <div data-role="page" id="<?= $page ?>" data-add-back-btn="true">
    <?php endif; ?>
        <div data-role="header">
            <div style="height:40px;vertical-align:text-bottom;">
                <h1 class="logo">HarvardCourses</h1>
            </div>
        </div>
        <div data-role="content">
            <ul data-role="listview">
            	<li>
            		<form action="/courses/searchCourses/" method="post">
            		    <input type="search" name="search" id="searc-basic" placeholder="type a course title, department, professor..." />
            		    <input type="submit" value="search" />
            		</form>
            	</li>
