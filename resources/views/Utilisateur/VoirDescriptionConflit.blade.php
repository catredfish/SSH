<div class="modal-dialog modal-dialog-centered">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <h4 id="titreModalModifierCreer" class="modal-title">Source des conflits</h4>
      <button type="button" class="close" data-dismiss="modal" onclick="supprimerRecreerModal()">&times;</button>
    </div>
    <div class="modal-body" id="contenuModalModifierAtelier">
      <div class="card voirDescriptionAteliersAucunEspace">
        <div id="contact-form" class="form-container" data-form-container="">
          <div class="input-container">
            <div class="row">
              <table id="aucuneCouleur">
                @foreach($model->getListeAteliersEnConflit() as $atelier)
                @if($model->getNumeroAtelierSelectionne() == $atelier->id)
                @foreach($atelier->messagesConflit as $messageConflit)
                
                  <tr>
                    <td>
                      <p>
                        <?php echo $messageConflit; ?>
                      </p>
                    </td>
                  </tr>
                @endforeach
                @endif
                @endforeach
              </table>
          </div>
        </div>
      </div>
    </div>
    </div>
    <link rel="stylesheet" type="text/css" href="css/Administrateur/VoirModifierAtelier.css">
    <div class="modal-footer">
      <input id="idAteliermodalModifierAtelier" name="idAtelier" value="0" hidden />
      <button type="button" class="btn btn-danger"  data-dismiss="modal" onclick="supprimerRecreerModal()">Fermer</button>
    </div>
  </div>
  <script src="js/Utilisateur/VoirDescriptionAtelier.js"></script>
</div>