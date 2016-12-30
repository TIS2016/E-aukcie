var elementsToHide = [
	top.document.getElementById('auctionRuntimeForm:j_id207'),
	top.document.getElementById('j_id177'),
	top.document.getElementById('j_id176').querySelector('h2'),
	top.document.getElementById('j_id327')
];

var outputFileName = top.document.getElementById('j_id176').querySelector('h3').innerHTML.match(/\"(.*)\"/)[1];

function screenshot() {
	elementsToHide.forEach(function(e) {
		e.style.display = 'none';
	});
	
	html2canvas(top.document.getElementById('j_id175'), {
		onrendered: function(canvas) {
			canvas.toBlob(function(blob) {
				saveAs(blob, outputFileName + '.png');
			}, 'image/png');
		},
	});
	
	elementsToHide.forEach(function(e) {
		e.style.display = '';
	});
}
