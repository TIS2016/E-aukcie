function screenshot() {
	html2canvas(top.document.body, {
		onrendered: function(canvas) {
			canvas.toBlob(function(blob) {
				saveAs(blob, 'output.png');
			}, 'image/png');
		}
	});
}
