!function(f){if(void 0!==f.fn.lc_switch)return;f.fn.lc_switch=function(e,r){return f.fn.lcs_destroy=function(){return f(this).each(function(){f(this).parents(".lcs_wrap").children().not("input").remove(),f(this).unwrap()}),!0},f.fn.lcs_on=function(){return f(this).each(function(){var s=f(this).parents(".lcs_wrap"),t=s.find("input");if("function"==typeof f.fn.prop?s.find("input").prop("checked",!0):s.find("input").attr("checked",!0),s.find("input").trigger("lcs-on"),s.find("input").trigger("lcs-statuschange"),s.find(".lcs_switch").removeClass("lcs_off").addClass("lcs_on"),s.find(".lcs_switch").hasClass("lcs_radio_switch")){var i=t.attr("name");s.parents("form").find("input[name="+i+"]").not(t).lcs_off()}}),!0},f.fn.lcs_off=function(){return f(this).each(function(){var s=f(this).parents(".lcs_wrap");"function"==typeof f.fn.prop?s.find("input").prop("checked",!1):s.find("input").attr("checked",!1),s.find("input").trigger("lcs-off"),s.find("input").trigger("lcs-statuschange"),s.find(".lcs_switch").removeClass("lcs_on").addClass("lcs_off")}),!0},this.each(function(){if(!f(this).parent().hasClass("lcs_wrap")){var s=void 0===e?"O":e,t=void 0===r?"X":r,i=s?'<div class="lcs_label lcs_label_on">'+s+"</div>":"",c=t?'<div class="lcs_label lcs_label_off">'+t+"</div>":"",n=!!f(this).is(":disabled"),a="";a+=!!f(this).is(":checked")?" lcs_on":" lcs_off",n&&(a+=" lcs_disabled");var l='<div class="lcs_switch '+a+'"><div class="lcs_cursor"></div>'+i+c+"</div>";!f(this).is(":input")||"checkbox"!=f(this).attr("type")&&"radio"!=f(this).attr("type")||(f(this).wrap('<div class="lcs_wrap"></div>'),f(this).parent().append(l),f(this).parent().find(".lcs_switch").addClass("lcs_"+f(this).attr("type")+"_switch"))}})},f(document).ready(function(){f(document).delegate(".lcs_switch:not(.lcs_disabled)","click tap",function(s){f(this).hasClass("lcs_on")?f(this).hasClass("lcs_radio_switch")||f(this).lcs_off():f(this).lcs_on()}),f(document).delegate(".lcs_wrap input","change",function(){f(this).is(":checked")?f(this).lcs_on():f(this).lcs_off()})})}(jQuery);
