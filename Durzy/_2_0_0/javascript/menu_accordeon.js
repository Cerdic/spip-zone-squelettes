//==============================================================
// Cette fonction assure le fonctionnent du menu 'accord�on' 
// appel�e depuis la page "durzy_general"
//==============================================================
$(document).ready(
	function()
	{
		$('#myAccordion').Accordion(
			{
				headerSelector	: 'dt',
				panelSelector	: 'dd',
				activeClass		: 'myAccordionActive',
				hoverClass		: 'myAccordionHover',
				panelHeight		: 100,
				speed			: 300
			}
		);
	}
);