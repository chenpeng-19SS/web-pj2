//如果file按钮选中了一个图片,将它的src传给img组件作为图片src,然后将无图片提示 noImageText 隐藏
function changePic() {
    let reads = new FileReader();
    let f = document.getElementById('file').files[0];
    reads.readAsDataURL(f);
    reads.onload = function(e) {
        document.getElementById('uploadedImage').src = this.result;
        document.getElementById('noImageText').hidden = true;
    };
}