$(function(){
	var selector=$('body');
	$(selector).delegate('#exportExcel','click','',exportExcel);
	function exportExcel()
	{
		window.open(exportUrl);
	}
});