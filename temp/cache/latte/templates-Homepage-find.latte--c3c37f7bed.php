<?php
// source: C:\xampp1\htdocs\dirlister\app\presenters/templates/Homepage/find.latte

use Latte\Runtime as LR;

class Templatec3c37f7bed extends Latte\Runtime\Template
{
	public $blocks = [
		'content' => 'blockContent',
		'_listing' => 'blockListing',
	];

	public $blockTypes = [
		'content' => 'html',
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
		if (isset($this->params['file'])) trigger_error('Variable $file overwritten in foreach on line 5, 28');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>
  <form id="findForm">
<select name="dir" id="dirSelect" >
  <option value="">všechny podsložky</option>
<?php
		$iterations = 0;
		foreach ($firstLevel as $file) {
			?>  <option value="<?php echo LR\Filters::escapeHtmlAttr($file) /* line 5 */ ?>"><?php echo LR\Filters::escapeHtmlText($file) /* line 5 */ ?></option>
<?php
			$iterations++;
		}
?>
</select>
  Hledaný soubor:<br>
  <input type="text" name="file" id="fileInput"><br>
  <input type="submit" value="Hledat">
</form>

    <div class="row">
    	<div class="col-8"<?php echo ' id="' . htmlSpecialChars($this->global->snippetDriver->getHtmlId('listing')) . '"' ?>>
<?php $this->renderBlock('_listing', $this->params) ?>
    	</div>
    </div>


  <script>
		 $('#findForm').submit (function(event){
			 event.preventDefault();
			 var dir = $('#dirSelect').val();
			 var file = $('#fileInput').val();
			 $.nette.ajax({
					 url: <?php echo LR\Filters::escapeJs($this->global->uiControl->link("find!")) ?>,
					 data: { dir :  dir, file : file }
			 });

		 });

		 //tree.expandAll();

  </script>

<?php
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
