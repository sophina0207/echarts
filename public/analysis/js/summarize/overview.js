$(function(){
	var selector=$(".wrap");
	$(selector).delegate('.urlImg',"mouseover","",overTip);
	$(selector).delegate('.urlImg',"mouseout","",outTip);
	function overTip(e)
	{
		var self=$(this);
		var value=self.attr('data-value');
		var toolTip = "<div id='tooltip' width='100px' height='12px' style='position:absolute;border:solid #aaa 1px;background-color:#F9F9F9'><b>" + value + "</b></div>";
		$("body").append(toolTip);
        $("#tooltip").css({
            "top" :e.pageY + "px",
            "left" :e.pageX + "px"
       });
		
	}
	function outTip()
	{
		$("#tooltip").remove();
	}
});