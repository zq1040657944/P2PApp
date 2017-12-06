$(function(){
	var $drag = $('.dragBtn'),
		$drop = $('.dropBox'),
		$mask = $('.dropMask'),
		speed = 300,
		state = false,
		iniX,iniY,posX,posY,winX = $(window).width(),winY = $(window).height();
	$(window).resize(function(){
		winX = $(window).width();
		winY = $(window).height();
	});
	var onClick = function(obj){
		switch(obj){
			case 'on':
				$drag.hide();
				$drop.css({'width':50,'height':50,'right':'auto','left':posX,'top':posY}).show().animate({width:300,height:300,left:winX/2-150,top:winY/2-150},speed,function(){state = true;$drop.find('.dropList').show();$mask.show()}) 
			break;
			case 'off':
				state = false;
				$drop.find('.dropList').hide()
				$mask.hide();
				$drop.css('right','auto').animate({width:50,height:50,left:posX,top:posY},speed,function(){$drop.hide();$drag.show();}) 
			break;
		}
	};
	$('.dropBox,.dragBtn,.dropMask').on('touchmove',
	function(e) {
		e.stopPropagation();
		e.preventDefault();
	});
	$drop.find('.dropSkin').on('touchend',function(){
		if(state)onClick('off');
	}); 	
	$mask.on('touchend',function(){
		if(state)onClick('off');
<<<<<<< HEAD
	});
});
=======
	}); 	
});

>>>>>>> dev3
