const dropZone = document.getElementById('drop-area');
const imgInput = document.getElementById('image-drop-inp'); //INPUT FORM
const preview = document.getElementById('preview'); // DIV

imgInput.addEventListener('change', previewImage);

function previewImage() {
    if (!imgInput.files || imgInput.files.length === 0) {
        return;
    }

    const img = URL.createObjectURL(imgInput.files[0]); // CREATES LINK FOR GRABBING IMAGE
    preview.innerHTML = 
    `<p style="text-align: center;">Preview:</p>
    <img src="${img}" alt="Image Preview" class="preview-img">`;
}

//COSMETICS v
dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.style.backgroundColor = 'red';
});

dropZone.addEventListener('dragleave', (e) => {
    e.preventDefault();
    dropZone.style.backgroundColor = 'transparent';
});
//COSMETICS ^

// UPON DROPPING IMAGE TRIGGER PREVIEW CREATION
dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.style.backgroundColor = 'transparent';

    const transfer = new DataTransfer();
    for (let i = 0; i < e.dataTransfer.files.length; i++) {
        transfer.items.add(e.dataTransfer.files[i]);
    }
    imgInput.files = transfer.files;

    previewImage();
});