<?php
// source: C:\xampp1\htdocs\dirlister\app\presenters/templates/@layout.latte

use Latte\Runtime as LR;

class Templateb999238634 extends Latte\Runtime\Template
{
	public $blocks = [
		'scripts' => 'blockScripts',
		'head' => 'blockHead',
	];

	public $blockTypes = [
		'scripts' => 'html',
		'head' => 'html',
	];


	function main()
	{
		extract($this->params);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

<title><?php
		if (isset($this->blockQueue["title"])) {
			$this->renderBlock('title', $this->params, function ($s, $type) {
				$_fi = new LR\FilterInfo($type);
				return LR\Filters::convertTo($_fi, 'html', $this->filters->filterContent('striphtml', $_fi, $s));
			});
			?> | <?php
		}
?>Dir lister</title>

<link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 12 */ ?>/css/style.css">
<link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 13 */ ?>/css/bootstrap.css">
<?php
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('scripts', get_defined_vars());
		?>	<?php
		$this->renderBlock('head', get_defined_vars());
?>

</head>

<body>

    <div class="top-header-wrapper">
        <div class="container">
            <img src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 32 */ ?>/images/fnol-logo-intranet.png" alt="" title="" height="75">
            <span class="text-right text-intranet">Intranet&nbsp;&nbsp;FN Olomouc</span>
        </div>
        <div class="container">&nbsp;</div>
    </div>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <div class="navbar-header">
                <span class="text-right">BezpListy</span>
                <a class="navbar-brand" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Homepage:default")) ?>"><span class="fa fa-home"></span></a>
                <a class="navbar-brand" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Homepage:find")) ?>">Hledat</span></a>
            </div>
        </div>
    </nav>
    <br>

	<div class="container">
<?php
		$iterations = 0;
		foreach ($flashes as $flash) {
			?>		<div<?php if ($_tmp = array_filter(['alert', 'alert-' . $flash->type])) echo ' class="', LR\Filters::escapeHtmlAttr(implode(" ", array_unique($_tmp))), '"' ?>><?php
			echo LR\Filters::escapeHtmlText($flash->message) /* line 50 */ ?></div>
<?php
			$iterations++;
		}
		$this->renderBlock('content', $this->params, 'html');
?>
	</div>
    <br>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 text-left">
                    <?php echo LR\Filters::escapeHtmlText(date('Y')) /* line 59 */ ?> &copy; FN Olomouc
                </div>
                <div class="col-sm-6 text-right">
                    i-Tree ver. 1.1&nbsp;
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
<?php
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['flash'])) trigger_error('Variable $flash overwritten in foreach on line 50');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockScripts($_args)
	{
		extract($_args);
		?><script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 15 */ ?>/js/jquery.min.js"></script>
	<script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 16 */ ?>/js/nette.ajax.js"></script>
		<link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 17 */ ?>/css/font-awesome.min.css">
<script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 18 */ ?>/js/bootstrap.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css">

<script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 22 */ ?>/js/main.js"></script>
<?php
	}


	function blockHead($_args)
	{
		
	}

}
