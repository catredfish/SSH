<!-- Contenu -->
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="idTitreModal">Ajouter un conférencier ou une conférencière</h4>
            <button type="button" class="close" data-dismiss="modal" onclick="supprimerRecreerModal()">&times;</button>
        </div>
        <div class="modal-body" id="idContenu">
            <div class="card">

                @csrf
                <div id="contact-form" class="form-container" data-form-container>
                    <div class="row">
                        <table id="tableauErreurs" style="{{count($errors->all()) > 0 ? "margin-bottom:1.4em;" : ""}}">
                            @foreach ($errors->all() as $message)
                                <tr>
                                    <td align="left"><label class="erreur">{{$message}}</label></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="input-container">

                        <!-- Téléversement -->
                        <form action="upload.php" method="post" id="formulaireTeleversement" enctype="multipart/form-data">
                            <button id="texteTeleversement" onclick="televersement()" type="button"
                                    class="btn btn-info">Sélectionnez l'image à téléverser
                            </button>
                            <input type="file" name="fileToUpload" id="fileToUpload"
                                   title="Sélectionnez l'image à téléverser" style="display: none"
                                   onchange='afficherNomFichier(fileToUpload.files[0].name)'>
                        </form>

                        <!-- Informations du conférencier -->
                        <div id="sectionCreationConferencier">
                            <form action="/CreerConferencier" method="post" id="formulaireConferencier">
                                <input id="photo" name="Photo" value="{{ old('Photo') }}" hidden="hidden">
                                <div class="row">
                                        <span class="req-input">
                                            <span class="input-status" data-toggle="tooltip" data-placement="top"
                                                  title="Veuillez entrer le nom du conférencier ou de la conférencière."> </span>
                                            <input type="text" name="Nom" id="nom" value='{{ old('Nom') }}' data-min-length="1"
                                                   placeholder="Nom">
                                        </span>
                                </div>
                                <div class="row">
                                        <span class="req-input">
                                            <span class="input-status" data-toggle="tooltip" data-placement="top"
                                                  title="Veuillez entrer le prénom du conférencier ou de la conférencière."> </span>
                                            <input type="text" name="Prenom" id="prenom" value='{{ old('Prenom') }}'
                                                   data-min-length="1" placeholder="Prénom">
                                        </span>
                                </div>
                                <div class="row">
                                        <span class="req-input">
                                            <span class="input-status" data-toggle="tooltip" data-placement="top"
                                                  title="Veuillez entrer le courriel du conférencier ou de la conférencière."> </span>
                                            <input type="email" name="Courriel" id="courriel" value='{{ old('Courriel') }}'
                                                   data-min-length="1" placeholder="Courriel">
                                        </span>
                                </div>
                                <div class="row">
                                        <span class="req-input">
                                            <span class="input-status" data-toggle="tooltip" data-placement="top"
                                                  title="Veuillez entrer l'expertise du conférencier ou de la conférencière."> </span>
                                            <input type="text" name="Expertise" id="expertise" value='{{ old('Expertise') }}'
                                                   data-min-length="1" placeholder="Expertise">
                                        </span>
                                </div>
                                <div class="row">
                                        <span id="BiographieBoite" class="req-input">
                                            <span class="input-status" data-toggle="tooltip" data-placement="top"
                                                  title="Veuillez entrer la biographie du conférencier ou de la conférencière."> </span>
                                            <textarea type="text" name='Biographie' id="biographie" maxlength="10000"
                                                      placeholder="Biographie"
                                                      rows="10">{{old('Biographie')}}</textarea>
                                        </span>
                                </div>
                                <div class="row submit-row">
                                    <button type="button" onclick="creerConferencier()" class="btn btn-block submit-form">Soumettre</button>
                                </div>
                            </form>

                            <!-- Script de validations -->
                            <script src="js/Administrateur/VoirCreerModifierConferencier.js" type="text/javascript"></script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="supprimerRecreerModal()">Fermer
            </button>
        </div>
    </div>
</div>