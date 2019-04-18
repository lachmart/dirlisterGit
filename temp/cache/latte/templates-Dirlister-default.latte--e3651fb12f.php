<?php
// source: C:\xampp1\htdocs\dirlister\app\presenters/templates/Dirlister/default.latte

use Latte\Runtime as LR;

class Templatee3651fb12f extends Latte\Runtime\Template
{
	public $blocks = [
		'content' => 'blockContent',
		'tree' => 'blockTree',
		'_wholeList' => 'blockWholeList',
		'_listing' => 'blockListing',
	];

	public $blockTypes = [
		'content' => 'html',
		'tree' => 'html',
		'_wholeList' => 'html',
		'_listing' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['file'])) trigger_error('Variable $file overwritten in foreach on line 28');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>

    <div class="row">
<?php
		$this->renderBlock('tree', get_defined_vars());
		?><div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('wholeList')) ?>"><?php
		$this->renderBlock('_wholeList', $this->params) ?></div>    </div>


  <script>
    var tree = $('#tree').tree({
				primaryKey: 'href',
				uiLibrary: 'bootstrap4',
//                iconsLibrary: 'fontawesome',
//                imageUrlField: 'flagUrl',
                dataSource: <?php echo LR\Filters::escapeJs($dirtree) /* line 47 */ ?>,
                border: true
            });
			tree.on('select', function (e, node, id) {
         //window.location.href = id;
				 $.nette.ajax({
				     url: <?php echo LR\Filters::escapeJs($this->global->uiControl->link("changeFolder!")) ?>,
				     data: { dir : id }
				 });
     });

		 //tree.expandAll();

  </script>

<?php
	}


	function blockTree($_args)
	{
?>            <div class="col-4">
                <ol class="breadcrumb">
                	<li>Struktura dokumentace:</li>
                </ol>
        		<div id="tree"></div>
        	</div>
<?php
	}


	function blockWholeList($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("wholeList", "static");
		?>    	<div class="col-8"<?php echo ' id="' . htmlSpecialChars($this->global->snippetDriver->getHtmlId('listing')) . '"' ?>>
<?php $this->renderBlock('_listing', $this->params) ?>
    	</div>
<?php
		$this->global->snippetDriver->leave();
		
	}


	function blockListing($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("listing", "static");
?>            <ol class="breadcrumb">
            	<li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("default")) ?>">Vybrane dokumenty: </a></li>
            	<li><?php echo LR\Filters::escapeHtmlText($dir) /* line 16 */ ?></li>
            </ol>
			<table class="table table-hover">
				<thead>
					<tr class="text-bold bg-primary">
    					<th class="w-75 p-2">Název souboru</th>
    					<th>Typ</th>
    					<th>Velikost[B]</th>
    					<th>Aktualizace</th>
					</tr>
				</thead>
				<tbody>
<?php
		$iterations = 0;
		foreach ($files as $file) {
?>    			    <tr>
    			        <td><a href=<?php echo LR\Filters::escapeHtmlAttrUnquoted(LR\Filters::safeUrl($file["href"])) /* line 29 */ ?> title=<?php
			echo LR\Filters::escapeHtmlAttrUnquoted($file["title"]) /* line 29 */ ?>> <?php echo LR\Filters::escapeHtmlText($file["text"]) /* line 29 */ ?></a></td>
   					    <td class="text-lowercase"> <?php echo LR\Filters::escapeHtmlText($file["ext"]) /* line 30 */ ?> </td>
    					<td class="text-right"> <?php echo LR\Filters::escapeHtmlText($file["size"]*1000) /* line 31 */ ?> </td>
    					<td class="text-right"> <?php echo LR\Filters::escapeHtmlText($file["date"]) /* line 32 */ ?></td>
    			    </tr>
<?php
			$iterations++;
		}
?>
				</tbody>
			</table>
<?php
		$this->global->snippetDriver->leave();
		
	}

}
