<!-- Gabarit -->
@extends ('Shared/Master_Layout')

<!-- Styles -->
@section ('styles')
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="css/Utilisateur/VoirListeConferenciers.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection

<!-- Variables -->
<?php
  $ID_TYPE_DE_COMPTE = "idTypeDeCompte";
  $ID_ADMINISTRATEUR = 2;
  $typeDeCompte = session()->get($ID_TYPE_DE_COMPTE);
?>

<!-- Contenu -->
@section ('content')
<div class="container">
  <div class="panel with-nav-tabs panel-primary">
    <div class="panel-heading">

      <!-- Onglets -->
      <ul class="nav nav-tabs">
        @if($typeDeCompte >= $ID_ADMINISTRATEUR)
          @if($model->getOngletSelectionne() == 1)
            <li class="active"><a onclick="MiseAJourOnglet(1)"  href="#tab1primary" data-toggle="tab">Liste des conférenciers actifs</a></li>
            <li><a onclick="MiseAJourOnglet(2)" href="#tab2primary" data-toggle="tab">Liste des conférenciers inactifs</a></li>
            @else
            <li ><a onclick="MiseAJourOnglet(1)"  href="#tab1primary" data-toggle="tab">Liste des conférenciers actifs</a></li>
            <li class="active"><a onclick="MiseAJourOnglet(2)" href="#tab2primary" data-toggle="tab">Liste des conférenciers inactifs</a></li>
          @endif
        @else
          <li class="active"><a  href="#tab1primary" data-toggle="tab">Liste des conférenciers</a></li>
          @endif
      </ul>

    <!-- Légende des boutons -->
    </div>
    <div class="panel-body">
      <button id='boutonLegende' class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Légende
      </button>

      @if($typeDeCompte >= $ID_ADMINISTRATEUR)
        @if($model->getOngletSelectionne() == "1")
        <button id='boutonCreer' class="btn btn-success" type="button" title="Ajouter un conférencier ou une conférencière" onclick="voirCreerConferencier()" data-toggle="modal" data-target="#modal"><span class="glyphicon glyphicon-plus"></span></button>
        @else
          <button id='boutonCreer' style="display:none" class="btn btn-success" type="button" title="Ajouter un conférencier ou une conférencière" onclick="voirCreerConferencier()" data-toggle="modal" data-target="#modal"><span class="glyphicon glyphicon-plus"></span></button>
        @endif
      @endif
        <div class="collapse" id="collapseExample">
        <div id="legende" class="card card-body">

          @if($typeDeCompte >= $ID_ADMINISTRATEUR)
          <table id="tableLegende">
            <thead>
              <tr class="tr-legende">
                <th class="th-legende">Bouton</th>
                <th class="th-legende">Description</th>
              </tr>
            </thead>
            <tr class="tr-legende">
              <td class="td-legende"><button type="button" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button></td>
              <td class="td-legende"><label>Permet d'ajouter un conférencier ou une conférencière</label></td>
            </tr>
            <tr class="tr-legende">
              <td class="td-legende"><button class="btn btn-info"><span class="glyphicon glyphicon-eye-open"></span></button></td>
              <td class="td-legende"><label>Permet de voir les informations d'un conférencier ou d'une conférencière</label></td>
            </tr>
            <tr class="tr-legende">
              <td class="td-legende"><button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span></button></td>
              <td class="td-legende"><label>Permet de modifier les informations d'un conférencier ou d'une conférencière</label></td>
            </tr>
            <tr class="tr-legende">
              <td class="td-legende"><button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></button></td>
              <td class="td-legende"><label>Permet de supprimer un conférencier ou une conférencière</label></td>
              </tr>
              </table>
            </div>
          </div>
      @else
          <table id="tableLegende">
            <thead>
            <tr class="tr-legende">
              <th class="th-legende">Bouton</th>
              <th class="th-legende">Description</th>
            </tr>
            </thead>
            <tr class="tr-legende">
              <td class="td-legende"><button class="btn btn-info"><span class="glyphicon glyphicon-eye-open"></span></button></td>
              <td class="td-legende"><label>Permet de voir les informations d'un conférencier ou d'une conférencière</label></td>
            </tr>
          </table>
        </div>
      </div>
        @endif
          <div class="tab-content">

            <!-- Liste des conférenciers actifs -->
            @if($model->getOngletSelectionne() == "1")
            <div class="tab-pane fade active in show" id="tab1primary">
              @else
                <div class="tab-pane fade" id="tab1primary">
                @endif
                  <div id="contact-form" class="form-container" data-form-container>
                    <div class="row">

                      <!-- Titre de la section -->
                      <div class="form-title">
                        @if($typeDeCompte >= $ID_ADMINISTRATEUR)
                        <div id="titre">Liste des conférenciers actifs</div>
                          @else
                          <div id="titre">Liste des conférenciers</div>
                        @endif
                      </div>
                    </div>

                    <!-- Noms des colonnes du tablesu -->
                    <table class="atelier table table-hover conferenciersActifs" id="formations">
                      <thead>
                      <tr>
                        <th scope="col" class="min-tablet-p">#</th>
                        <th class='th-titre all' scope="col">Nom</th>
                        <th scope="col" class="min-tablet-p">Prénom</th>
                        <th scope="col" class="min-tablet-p">Expertise</th>
                        <th scope="col" class="thActions" class="all">Actions</th>
                      </tr>
                      </thead>
                      <tbody>

                      <!-- Liste des conférenciers actifs -->
                        @for($index = 0; $index < count($model->getListeConferenciersActifs()); $index ++)
                        <tr>
                          <th scope="row">{{$index + 1}}</th>
                          <td>{{$model->getListeConferenciersActifs()[$index]->Nom}}</td>
                          <td>{{$model->getListeConferenciersActifs()[$index]->Prenom}}</td>
                          <td>{{$model->getListeConferenciersActifs()[$index]->Expertise}}</td>
                          <td>

                            <!-- Option pour tous -->
                            <button type="button" class="btn btn-info boutonHauteur" onclick="voirConferencier('{{$model->getListeConferenciersActifs()[$index]->id}}')" data-toggle="modal" data-target="#modal" title="Voir les informations du conférencier ou de la conférencière"><i class="fa fa-eye"></i></button>

                            <!-- Options d'administrateurs -->
                            @if($typeDeCompte >= $ID_ADMINISTRATEUR)
                              <button type="button" class="btn btn-warning boutonHauteur" title="Modifier les informations du conférencier ou de la conférencière" onclick="voirModifierConferencier('{{$model->getListeConferenciersActifs()[$index]->id}}')" data-toggle="modal" data-target="#modal"><i class="fa fa-pencil"></i></button>
                              <button type="button" class="btn btn-danger boutonHauteur" title="Supprimer le conférencier ou la conférencière" onclick="voirSupprimerConferencier('{{$model->getListeConferenciersActifs()[$index]->id}}')" data-toggle="modal" data-target="#modal"><i class="fa fa-times iconeSupprimer"></i></button>
                            @endif
                          </td>
                          </tr>
                          @endfor
                        </tbody>
                      </table>
                    </div>
                </div>

                <!-- Liste des conférenciers inactifs -->
                @if($model->getOngletSelectionne() == "0")
                  <div class="tab-pane fade active in show" id="tab2primary">
                    @else
                      <div class="tab-pane fade" id="tab2primary">
                        @endif
                      <div id="contact-form" class="form-container" data-form-container>
                        <div class="row">

                          <!-- Titre de la section -->
                          <div class="form-title">
                              <div id="titre">Liste des conférenciers inactifs</div>
                          </div>
                        </div>

                        <!-- Noms des colonnes du tablesu -->
                        <table class="atelier table table-hover conferenciersArchives" id="formations">
                          <thead>
                          <tr>
                            <th scope="col" class="min-tablet-p">#</th>
                            <th class='th-titre all' scope="col">Nom</th>
                            <th scope="col" class="min-tablet-p">Prénom</th>
                            <th scope="col" class="min-tablet-p">Expertise</th>
                            <th scope="col" class="thActions" class="all">Actions</th>
                          </tr>
                          </thead>
                          <tbody>

                          <!-- Liste des conférenciers inactifs -->
                          @for($index = 0; $index < count($model->getListeConferenciersInactifs()); $index ++)
                            <tr>
                              <th scope="row">{{$index + 1}}</th>
                              <td>{{$model->getListeConferenciersInactifs()[$index]->Nom}}</td>
                              <td>{{$model->getListeConferenciersInactifs()[$index]->Prenom}}</td>
                              <td>{{$model->getListeConferenciersInactifs()[$index]->Expertise}}</td>
                              <td>
                                <!-- Option pour tous -->
                                <button type="button" class="btn btn-info boutonHauteur" onclick="voirConferencier('{{$model->getListeConferenciersInactifs()[$index]->id}}')" data-toggle="modal" data-target="#modal" title="Voir les informations du conférencier ou de la conférencière"><i class="fa fa-eye"></i></button>

                                <!-- Options d'administrateurs -->
                                @if($typeDeCompte >= $ID_ADMINISTRATEUR)
                                <button type="button" class="btn btn-warning boutonHauteur" title="Modifier les informations du conférencier ou de la conférencière" onclick="voirModifierConferencier('{{$model->getListeConferenciersInactifs()[$index]->id}}')" data-toggle="modal" data-target="#modal"><i class="fa fa-pencil"></i></button>
                                <button type="button" class="btn btn-danger boutonHauteur" title="Supprimer le conférencier ou la conférencière" onclick="voirSupprimerConferencier('{{$model->getListeConferenciersInactifs()[$index]->id}}')" data-toggle="modal" data-target="#modal"><i class="fa fa-times iconeSupprimer"></i></button>
                                @endif
                              </td>
                            </tr>
                          @endfor
                          </tbody>
                        </table>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Fenêtre modale -->
      <div id="sectionPourModale">
        <div class="modal fade" id="modal" role="dialog">
        </div>
      </div>

      <!-- Scripts -->
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
      <script src="js/Utilisateur/VoirListeConferenciers.js"></script>
      @endsection
