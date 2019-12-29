<!-- Gabarit -->
@extends ('Shared.Master_Layout')

<!-- Styles -->
@section ('styles')
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="css/SuperAdministrateur/VoirListeAdministrateurs.css">
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
        @if($model->getOngletSelectionne() == 1)
          <li class="active"><a onclick="MiseAJourOnglet(1)"  href="#tab1primary" data-toggle="tab">Liste des employés</a></li>
          <li><a onclick="MiseAJourOnglet(2)" href="#tab2primary" data-toggle="tab">Liste des visiteurs</a></li>
          <li><a onclick="MiseAJourOnglet(3)" href="#tab3primary" data-toggle="tab">Liste des élèves</a></li>
          @elseif($model->getOngletSelectionne() == 2)
          <li ><a onclick="MiseAJourOnglet(1)"  href="#tab1primary" data-toggle="tab">Liste des élèves</a></li>
          <li class="active"><a onclick="MiseAJourOnglet(2)" href="#tab2primary" data-toggle="tab">Liste des visiteurs</a></li>
          <li><a onclick="MiseAJourOnglet(3)" href="#tab3primary" data-toggle="tab">Liste des élèves</a></li>
          @else
          <li ><a onclick="MiseAJourOnglet(1)"  href="#tab1primary" data-toggle="tab">Liste des employés</a></li>
          <li><a onclick="MiseAJourOnglet(2)" href="#tab2primary" data-toggle="tab">Liste des visiteurs</a></li>
          <li class="active"><a onclick="MiseAJourOnglet(3)" href="#tab3primary" data-toggle="tab">Liste des élèves</a></li>
        @endif
      </ul>

    <!-- Légende des boutons -->
    </div>
    <div class="panel-body">
      <button id='boutonLegende' class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        Légende
      </button>

        <div class="collapse" id="collapseExample">
        <div id="legende" class="card card-body">
          <table id="tableLegende">
            <thead>
              <tr class="tr-legende">
                <th class="th-legende">Bouton</th>
                <th class="th-legende">Description</th>
              </tr>
            </thead>
            <tr class="tr-legende">
              <td class="td-legende"><button type="button" class="btn btn-warning permissions"><i class="fa fa-user"></i></button></td>
              <td class="td-legende"><label>Montre que le compte est de type administrateur et permet de rétrograder le compte au type d'utilisateur</label></td>
            </tr>
            <tr class="tr-legende">
              <td class="td-legende"><button class="btn btn-info permissions"><i class="fa fa-user-o"></i></button></td>
              <td class="td-legende"><label>Montre que le compte est de type utilisateur et permet de promouvoir le compte au type d'administrateur</label></td>
            </tr>
            <tr class="tr-legende">
              <td class="td-legende"><button type="button" class="btn btn-success"><i class="fa fa-flag"></i></button></td>
              <td class="td-legende"><label>Montre que le compte est activé et permet de désactiver le compte</label></td>
            </tr>
            <tr class="tr-legende">
              <td class="td-legende"><button type="button" class="btn btn-danger"><i class="fa fa-flag-o"></i></button></td>
              <td class="td-legende"><label>Montre que le compte est désactivé et permet d'activer le compte</label></td>
              </tr>
              </table>
            </div>
          </div>
          <div class="tab-content">

            <!-- Liste des employés -->
            @if($model->getOngletSelectionne() == "1")
            <div class="tab-pane fade active in show" id="tab1primary">
              @else
                <div class="tab-pane fade" id="tab1primary">
                @endif
                  <div id="contact-form" class="form-container" data-form-container>
                    <div class="row">

                      <!-- Titre de la section -->
                      <div class="form-title">
                        <div id="titre">Liste des employés</div>
                      </div>
                    </div>

                    <!-- Noms des colonnes du tablesu -->
                    <table class="atelier table table-hover employes" id="formations">
                      <thead>
                        <tr>
                          <th scope="col" class="min-tablet-p">#</th>
                          <th class='th-titre all' scope="col">Nom</th>
                          <th scope="col" class="min-tablet-p">Prénom</th>
                          <th scope="col" class="min-tablet-p">Courriel</th>
                          <th scope="col" class="thActions all">Actions</th>
                        </tr>
                      </thead>
                      <tbody>

                      <!-- Liste des employés -->
                        @for($index = 0; $index < count($model->getListeComptesEmployes()); $index ++)
                        <tr>
                          <th scope="row">{{$index + 1}}</th>
                          <td>{{$model->getListeComptesEmployes()[$index]->Nom}}</td>
                          <td>{{$model->getListeComptesEmployes()[$index]->Prenom}}</td>
                          <td>{{$model->getListeComptesEmployes()[$index]->Courriel}}</td>
                          <td>

                            <!-- Permission du compte -->
                            @if($model->getListeComptesEmployes()[$index]->idTypeCompte == '2')
                              <button type="button" class="btn btn-warning permissions" onclick="voirModal('{{$model->getListeComptesEmployes()[$index]->id}}', '1', 'RetrograderAdministrateur')" data-toggle="modal" data-target="#modal" title="Compte admnistrateur"><i class="fa fa-user"></i></button>
                            @elseif($model->getListeComptesEmployes()[$index]->idTypeCompte == '1')
                              <button type="button" class="btn btn-info permissions" onclick="voirModal('{{$model->getListeComptesEmployes()[$index]->id}}', '1', 'PromouvoirUtilisateur')" data-toggle="modal" data-target="#modal" title="Compte utilisateur"><i class="fa fa-user-o"></i></button>
                            @endif

                            <!-- Statut du compte -->
                            @if($model->getListeComptesEmployes()[$index]->Actif)
                            <button type="button" class="btn btn-success" onclick="voirModal('{{$model->getListeComptesEmployes()[$index]->id}}', '1', 'DesactiverCompte')" data-toggle="modal" data-target="#modal" title="Compte activé"><i class="fa fa-flag"></i></button>
                            @else
                              <button type="button" class="btn btn-danger" onclick="voirModal('{{$model->getListeComptesEmployes()[$index]->id}}', '1', 'ActiverCompte')" data-toggle="modal" data-target="#modal" title="Compte désactivé"><i class="fa fa-flag-o"></i></button>
                            @endif

                          </td>
                          </tr>
                          @endfor
                        </tbody>
                      </table>
                    </div>
                </div>

                <!-- Liste des visiteurs -->
                @if($model->getOngletSelectionne() == "2")
                  <div class="tab-pane fade active in show" id="tab2primary">
                    @else
                      <div class="tab-pane fade" id="tab2primary">
                        @endif
                        <div id="contact-form" class="form-container" data-form-container>
                          <div class="row">

                            <!-- Titre de la section -->
                            <div class="form-title">
                              <div id="titre">Liste des visiteurs</div>
                            </div>
                          </div>

                          <!-- Noms des colonnes du tablesu -->
                          <table class="atelier table table-hover visiteurs" id="formations">
                            <thead>
                            <tr>
                              <th scope="col" class="min-tablet-p">#</th>
                              <th class='th-titre all' scope="col">Nom</th>
                              <th scope="col" class="min-tablet-p">Prénom</th>
                              <th scope="col" class="min-tablet-p">Courriel</th>
                              <th scope="col" class="thActions all">Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            <!-- Liste des visiteurs -->
                            @for($index = 0; $index < count($model->getListeComptesVisiteurs()); $index ++)
                              <tr>
                                <th scope="row">{{$index + 1}}</th>
                                <td>{{$model->getListeComptesVisiteurs()[$index]->Nom}}</td>
                                <td>{{$model->getListeComptesVisiteurs()[$index]->Prenom}}</td>
                                <td>{{$model->getListeComptesVisiteurs()[$index]->Courriel}}</td>
                                <td>
                                  <!-- Permission du compte -->
                                  @if($model->getListeComptesVisiteurs()[$index]->idTypeCompte == '2')
                                    <button type="button" class="btn btn-warning permissions" onclick="voirModal('{{$model->getListeComptesVisiteurs()[$index]->id}}', '2', 'RetrograderAdministrateur')" data-toggle="modal" data-target="#modal" title="Compte admnistrateur"><i class="fa fa-user"></i></button>
                                  @elseif($model->getListeComptesVisiteurs()[$index]->idTypeCompte == '1')
                                    <button type="button" class="btn btn-info permissions" onclick="voirModal('{{$model->getListeComptesVisiteurs()[$index]->id}}', '2', 'PromouvoirUtilisateur')" data-toggle="modal" data-target="#modal" title="Compte utilisateur"><i class="fa fa-user-o"></i></button>
                                  @endif

                                <!-- Statut du compte -->
                                  @if($model->getListeComptesVisiteurs()[$index]->Actif)
                                    <button type="button" class="btn btn-success" onclick="voirModal('{{$model->getListeComptesVisiteurs()[$index]->id}}', '2', 'DesactiverCompte')" data-toggle="modal" data-target="#modal" title="Compte activé"><i class="fa fa-flag"></i></button>
                                  @else
                                    <button type="button" class="btn btn-danger" onclick="voirModal('{{$model->getListeComptesVisiteurs()[$index]->id}}', '2', 'ActiverCompte')" data-toggle="modal" data-target="#modal" title="Compte désactivé"><i class="fa fa-flag-o"></i></button>
                                  @endif
                                </td>
                              </tr>
                            @endfor
                            </tbody>
                          </table>
                        </div>
                      </div>


                      <!-- Liste des élèves -->
                      @if($model->getOngletSelectionne() == "3")
                        <div class="tab-pane fade active in show" id="tab3primary">
                          @else
                            <div class="tab-pane fade" id="tab3primary">
                              @endif
                              <div id="contact-form" class="form-container" data-form-container>
                                <div class="row">

                                  <!-- Titre de la section -->
                                  <div class="form-title">
                                    <div id="titre">Liste des élèves</div>
                                  </div>
                                </div>

                                <!-- Noms des colonnes du tablesu -->
                                <table class="atelier table table-hover eleves" id="formations">
                                  <thead>
                                  <tr>
                                    <th scope="col" class="min-tablet-p">#</th>
                                    <th class='th-titre all' scope="col">Nom</th>
                                    <th scope="col" class="min-tablet-p">Prénom</th>
                                    <th scope="col" class="min-tablet-p">Courriel</th>
                                    <th scope="col" class="thActions all">Actions</th>
                                  </tr>
                                  </thead>
                                  <tbody>

                                  <!-- Liste des élèves -->
                                  @for($index = 0; $index < count($model->getListeComptesEleves()); $index ++)
                                    <tr>
                                      <th scope="row">{{$index + 1}}</th>
                                      <td>{{$model->getListeComptesEleves()[$index]->Nom}}</td>
                                      <td>{{$model->getListeComptesEleves()[$index]->Prenom}}</td>
                                      <td>{{$model->getListeComptesEleves()[$index]->Courriel}}</td>
                                      <td>
                                        <!-- Permission du compte -->
                                        @if($model->getListeComptesEleves()[$index]->idTypeCompte == '2')
                                          <button type="button" class="btn btn-warning permissions" onclick="voirModal('{{$model->getListeComptesEleves()[$index]->id}}', '3', 'RetrograderAdministrateur')" data-toggle="modal" data-target="#modal" title="Compte admnistrateur"><i class="fa fa-user"></i></button>
                                        @elseif($model->getListeComptesEleves()[$index]->idTypeCompte == '1')
                                          <button type="button" class="btn btn-info permissions" onclick="voirModal('{{$model->getListeComptesEleves()[$index]->id}}', '3', 'PromouvoirUtilisateur')" data-toggle="modal" data-target="#modal" title="Compte utilisateur"><i class="fa fa-user-o"></i></button>
                                        @endif

                                      <!-- Statut du compte -->
                                        @if($model->getListeComptesEleves()[$index]->Actif)
                                          <button type="button" class="btn btn-success" onclick="voirModal('{{$model->getListeComptesEleves()[$index]->id}}', '3', 'DesactiverCompte')" data-toggle="modal" data-target="#modal" title="Compte activé"><i class="fa fa-flag"></i></button>
                                        @else
                                          <button type="button" class="btn btn-danger" onclick="voirModal('{{$model->getListeComptesEleves()[$index]->id}}', '3', 'ActiverCompte')" data-toggle="modal" data-target="#modal" title="Compte désactivé"><i class="fa fa-flag-o"></i></button>
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
  </div>

<!-- Fenêtre modale -->
@csrf
<div id="sectionPourModale">
  <div class="modal fade" id="modal" role="dialog">
  </div>
</div>

<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="js/SuperAdministrateur/VoirListeAdministrateurs.js"></script>
@endsection