/**
 * Opens an image and displays it on the defined html img element
 * @param {*} srcId An <input> element of type="file" that opens the image 
 * @param {*} targetId The id of the <img> element that should display the open image
 * @param {*} errorMSg The id of a hidden input field which value contains the error message text
 * @param {*} defaultImg The id of a hidden input field which value contains the route for the default image
 */
function selectImage(srcId, targetId, errorMsg, defaultImg) {

    const acceptedImageTypes = ['image/png', 'image/jpg', 'image/jpeg'];

    var src = document.getElementById(srcId);
    var target = document.getElementById(targetId);

    if(src.files[0] == undefined) {
        src.value = "";
        target.src = defaultImg;

    } else if(src.files[0].size > 7244183 // 6MB?
        || !acceptedImageTypes.includes(src.files[0]['type']) ) { // valid image file?
        alert(errorMsg);
        src.value = "";
        target.src = defaultImg;

    } else {
        showImgSelection(src, target); // if everything went as planned, we display the image immediately
    }
}

/**
 * Displays the current avatar image, both on the passed img as well as on the navigation bar
 */
function showImgSelection(src, target) {
    var fr = new FileReader();

    fr.onload = function(e) {
        target.src = this.result;
    };

    fr.readAsDataURL(src.files[0]);

}

function cancelImgSelection(srcId, targetId, defaultImg) {
    var src = document.getElementById(srcId);
    var target = document.getElementById(targetId);
    src.value = "";
    target.src = defaultImg;
}