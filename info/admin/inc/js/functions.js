function targetArea() {
	var element = document.getElementById('wpc_s_22');
	return null !== element ? element : false;
}
window.addEventListener('load', function() {
	var arr = targetArea() ? targetArea().value.split(',') : false;
	for(var i=0; i<arr.length; ++i){
		if(arr[i] !== '' && null !== arr[i]) {
			var div = document.createElement('div');
    		div.setAttribute('id', arr[i].replace(/[^a-zA-Z0-9]/g, '-'));
			div.innerHTML = '<span class="cont" onclick="editWord(this,\''+arr[i]+'\');"  title="edit">'+arr[i]+'</span><span class="del" onclick="removeBanned(\''+arr[i]+'\')" title="remove"></span>';
			document.getElementById("banned-words").appendChild(div);
		}
	};
}, false);
function addBanned() {
	var word = window.prompt('Type the word you wish to add to the blacklist:');
	if(word == 0 || word === null) {
        if(word !== null)
            alert('Please enter a word');
        return false;
	}
	word = word.replace(/"/g, '');
	var eles = targetArea().value.split(',');
	var count = 0;
	for(var i=0; i<eles.length; ++i){
		if(eles[i] !== word) {
			count += 0;
		} else {
			count += 1;
		}
	};
	if( count > 0 ) {
		alert('Word "'+word+'" already added');
	} else {
		targetArea().value += word+',';
		var div = document.createElement('div');
		div.setAttribute('id', word.replace(/[^a-zA-Z0-9]/g, '-'));
		div.innerHTML = '<span class="cont" onclick="editWord(this,\''+word.replace(/'/g, "\\'").replace(/"/g, '')+'\');" title="edit">'+word+'</span><span class="del" onclick="removeBanned(\''+word.replace(/'/g, "\\'").replace(/"/g, '')+'\')" title="remove"></span>';
		document.getElementById("banned-words").appendChild(div);
	}
}
function removeBanned(word) {
	document.getElementById(word.replace(/[^a-zA-Z0-9]/g, '-')).remove();
	var eles = targetArea().value.split(',');
	targetArea().value = '';
	for(var i=0; i<eles.length; ++i){
		if(eles[i] !== word) {
			targetArea().value += eles[i]+',';
		}
	};
}
function editWord(selector, word) {
	var edit = window.prompt('Edit word:', word);
	if(edit == 0 || edit === null) {
        if(edit !== null)
            alert('Please enter a word');
        return false;
	}
	edit = edit.replace(/"/g, '');
	var eles = targetArea().value.split(',');
	var count = 0;
	for(var i=0; i<eles.length; ++i){
		if(eles[i] !== edit) {
			count += 0;
		} else {
			count += 1;
		}
	};
	if(count > 0) {
		if( word !== edit )
			alert('This word already exists.');
		return false;
	} else {
		targetArea().value = '';
		for(var i=0; i<eles.length; ++i){
			if(eles[i] == word) {
				targetArea().value += edit+',';
			} else {
				targetArea().value += eles[i] == 0 || null == eles[i] ? '' : eles[i]+',';			
			}
		};
	}
	selector.innerHTML = edit;
	selector.setAttribute('onclick', 'editWord(this, \''+edit.replace(/'/g, "\\'").replace(/"/g, '')+'\');');
	selector.parentElement.setAttribute('id', edit.replace(/[^a-zA-Z0-9]/g, '-'));
	document.querySelector( '#'+selector.parentElement.getAttribute('id')+' .del' ).setAttribute('onclick', 'removeBanned(\''+edit.replace(/'/g, "\\'").replace(/"/g, '')+'\');');
}
function wpc_submit() {
	var elements = document.getElementsByClassName("wpcTrans");
	var content = '{';
	for(var i=0; i<elements.length; ++i){
		value = elements[i].value;
		value = value.replace(/"/g, "'");
		if( value.trim()==null || value.trim()==""|| value===" " ) {
		} else {
			var index = elements[i].getAttribute('id').replace('case-', '');
			content += ', "'+index+'" : "'+value+'"';
		}
	};
	content += '}';
	content = content.replace('{,', '{');
	document.getElementById('wpc-translations').value = content;
}
function load_trans(id, value) {
	document.getElementById('case-'+id).value = value;
}
function wpc_showHide(id, focus) {
	element = document.getElementById(id);
	if( null !== element) {
		if( element.style.display == 'block' )
			element.style.display = 'none';
		else
			element.style.display = 'block';
	}
	if( focus ) {
		if( null !== document.getElementById(focus) ) {
			document.getElementById(focus).select();
		}
	}
}

function helpToggle(target, ele) {
	if( ele.className.indexOf('active') > -1 ) {
		document.getElementById('help_s_'+target).style.display = 'none';
		ele.className  = 'wpc_help';
	} else {
		document.getElementById('help_s_'+target).style.display = '';
		ele.className  = 'wpc_help active';
	}
}
function audioPlay(elem) {
	var audio = document.getElementById('wpc-audio');
	audio.play();
	elem.innerHTML = "Stop";
	elem.setAttribute('onclick', "audioStop(this)");
}
function audioStop(elem) {
	var audio = document.getElementById('wpc-audio');
	var btn = document.getElementById('play-audio');
	audio.currentTime = 0;
	audio.pause();
	btn.setAttribute('onclick', "audioPlay(this)");
	elem.innerHTML = "Stopped";
	setTimeout (function() { btn.innerHTML = "Play"; },1000);
}
function wpc_uncheck_rdr(name) {
	var tars = document.getElementsByName(name);
	for(var i=0; i<tars.length; ++i){
		tars[i].checked = false;
	};
}
window.addEventListener('load', function() {
	if( null !== document.getElementById('enable_translation') ) {
		if( document.getElementById('enable_translation').checked ) {
			if(null !== document.getElementById('enableTrans')) document.getElementById('enableTrans').value = 'on';
			if(null !== document.getElementById('label-to-submit')) document.getElementById('label-to-submit').style.display = 'none';
		} else {
			if(null !== document.getElementById('enableTrans')) document.getElementById('enableTrans').value = '';
			if(null !== document.getElementById('label-to-submit')) document.getElementById('label-to-submit').style.display = 'block';
			if(null !== document.getElementById('wpc-note')) document.getElementById('wpc-note').style.display = 'none';
			if(null !== document.getElementById('wpc-add-trans')) document.getElementById('wpc-add-trans').style.display = 'none';
			if(null !== document.getElementById('wpc-trans')) document.getElementById('wpc-trans').style.display = 'none';
			if(null !== document.getElementById('wpc_contr')) document.getElementById('wpc_contr').style.display = 'none';
		}
	}
}, false);
function enableTrans(ele) {
	if( ele.checked ) {
		if(null !== document.getElementById('enableTrans')) document.getElementById('enableTrans').value = 'on';
		if(null !== document.getElementById('label-to-submit')) document.getElementById('label-to-submit').style.display = 'none';
		if(null !== document.getElementById('wpc-note')) document.getElementById('wpc-note').style.display = '';
		if(null !== document.getElementById('wpc-add-trans')) document.getElementById('wpc-add-trans').style.display = '';
		if(null !== document.getElementById('wpc-trans')) document.getElementById('wpc-trans').style.display = '';
		if(null !== document.getElementById('wpc_contr')) document.getElementById('wpc_contr').style.display = '';
	} else {
		if(null !== document.getElementById('enableTrans')) document.getElementById('enableTrans').value = '';
		if(null !== document.getElementById('label-to-submit')) document.getElementById('label-to-submit').style.display = 'block';
		if(null !== document.getElementById('wpc-note')) document.getElementById('wpc-note').style.display = 'none';
		if(null !== document.getElementById('wpc-add-trans')) document.getElementById('wpc-add-trans').style.display = 'none';
		if(null !== document.getElementById('wpc-trans')) document.getElementById('wpc-trans').style.display = 'none';
		if(null !== document.getElementById('wpc_contr')) document.getElementById('wpc_contr').style.display = 'none';
	}
}
function wpc_submitAdditional() {
	var elements = document.getElementsByClassName("wpcTransAddi");
	var content = '{';
	for(var i=0; i<elements.length; ++i){
		value = elements[i].value;
		value = value.replace(/"/g, "'");
		if( value.trim()==null || value.trim()==""|| value===" " ) {
		} else {
			var index = elements[i].getAttribute('id');
			content += ', "'+index+'" : "'+value+'"';
		}
	};
	content += '}';
	content = content.replace('{,', '{');
	document.getElementById('wpc-additional-trans').value = content;
}
function load_additional_trans(original, value) {
	document.getElementById(original).value = value;
}