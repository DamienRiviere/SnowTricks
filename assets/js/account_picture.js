$("#picture_picture").on("change", function () {
    //get the file name
    let file = $(this).val();
    let fileName = file.split("\\");

    //replace the "Choose a file" label
    $(this).next(".custom-file-label").html(fileName[2]);
});