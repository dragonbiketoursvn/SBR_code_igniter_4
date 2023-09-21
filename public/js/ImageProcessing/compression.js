// code to compress image files before uploading via form

(function () {
  const fileInputs = document.querySelectorAll('input[type="file"]');

  if (fileInputs.length > 0) {
    fileInputs.forEach((fileInput) => {
      const captureImage = (image) => {
        const imageFile = fileInput.files[0];
        const imageURL = URL.createObjectURL(imageFile);
        image.src = imageURL;
      };

      const toBlobCallback = (blob) => {
        const myFile = new File([blob], String(Date.now()) + ".jpg", {
          type: blob.type,
        });
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(myFile);
        fileInput.files = dataTransfer.files; // fileInput referenced from outer scope
        console.log(myFile);
      };

      // using as evt listener ensures the image has loaded before canvas is created
      const prepareCanvasForCompression = (evt) => {
        const image = evt.target;
        const canvas = document.createElement("canvas");
        canvas.width = image.width;
        canvas.height = image.height;
        const ctx = canvas.getContext("2d");
        ctx.drawImage(image, 0, 0, canvas.width, canvas.height);
        canvas.toBlob(toBlobCallback, "image/jpeg", 0.8);
      };

      const compressAndAttachFile = (evt) => {
        const image = document.createElement("img"); // needed as input by other callbacks
        image.addEventListener("load", prepareCanvasForCompression); // only way to ensure img has loaded before canvas is created
        captureImage(image); // captures imageFile from fileInput, creates and assigns URL to image.src
      };

      fileInput.addEventListener("change", compressAndAttachFile);
    });
  }
})();
