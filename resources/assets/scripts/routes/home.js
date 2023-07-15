export default {
  init() {
    $(".usp-name input").attr("placeholder", "Emri dhe Mbiemri");
    $(".usp-title input").attr("placeholder", "Qyteti");
    $(".usp-custom input").attr("placeholder", "Email");
    $("#usp-upload-message").html("Foto e kuponit fiskal");
    $(".usp-input").text('');
    $('input[type="file"]' ).wrap( '<div  class="containertitle"></div>' );
    $('.containertitle').html('<input name="user-submitted-image[]" id="files" type="file" size="25" class="usp-input usp-clone" data-parsley-excluded="true" accept="image/*"><label for="files">Ngarko</label>');
    $(".usp-submit").val('Bëhu pjesë e lojës');
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};
