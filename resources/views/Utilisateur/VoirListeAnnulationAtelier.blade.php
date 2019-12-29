
@extends ('Shared/Master_Layout')

@section ('styles')
<!-- Styles -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="css/Utilisateur/VoirListeAnnulationAtelier.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
@endsection

@section ('content')
<div class="container">

    <input id="inputNumeroOngletSelectionne" hidden="hidden" value="{{$model->getOngletSelectionne()}}">
    <input id="inputNumeroCampusSelectionne" hidden="hidden" value="{{$model->getNumeroCampus()}}">
    <input id="inputDateSelectionnee" hidden="hidden" value="{{$model->getDateSelectionnee()}}">

    <div class="col-md-12">
        <div class="card">
            <button id='boutonLegende' class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Légende
            </button>
            <div class="collapse" id="collapseExample">
                <div id="legende" class="card card-body">
                    <table>
                        <thead>
                            <tr class="tr-legende">
                                <th class="th-legende">Bouton</th>
                                <th class="th-legende">Description</th>
                            </tr>
                        </thead>
                        <tr class="tr-legende">
                            <td class="td-legende"><button type="button" class="btnParticipation btn btn-danger"><i class="fa fa-times"></i></button></td>
                            <td class="td-legende2"><label>Permet d'annuler un atelier.</label></td>
                        </tr>
                    </table>
                </div>
            </div>
            <form>
                <div id="contact-form" class="form-container" data-form-container>
                    <div class="row">
                        <div class="form-title">
                            <div id="titre">Liste des ateliers de formation</div>
                        </div>
                    </div>

                    <!--Trier par date-->
                    <label class="labelInputDate">Choisir une date : </label>
                    <input class="inputDate" type="date" value="{{$model->getDateSelectionnee()}}">

                    <!-- Campus -->
                    <select id="campusListeAteliersDisponibles" class="campus">
                        @foreach($model->getListeCampus() as $campus)
                        @if($model->getNumeroCampus() == $campus->id)
                        <option selected="" value="{{$campus->id}}">{{$campus->Nom}}</option>
                        @else
                        <option value="{{$campus->id}}">{{$campus->Nom}}</option>
                        @endif
                        @endforeach
                    </select>
                    <label  class="campus">Campus : </label>
                    <div class="input-container">
                        @csrf
                    </div>

                    <!-- Liste -->
                    <table class="atelier table table-hover" id="formations">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th class='th-titre' scope="col">Titre</th>
                                <th scope="col">Campus</th>
                                <th scope="col">Local</th>
                                <th class='th-date' scope="col">Date</th>
                                <th scope="col">Début</th>
                                <th scope="col">Places</th>
                                <th scope="col" id="thActions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($index = 0; $index < count($model->getListeAteliers()); $index ++)
                            <tr>
                                <th scope="row">{{$index + 1}}</th>
                                <td>{{$model->getListeAteliers()[$index]->Nom}}</td>
                                <td>{{$model->getListeCampus()[($model->getListeAteliers()[$index]->idCampus) - 1]->Nom}}</td>
                                <td>{{$model->getListeAteliers()[$index]->Endroit}}</td>
                                <td>{{$model->getListeAteliers()[$index]->DateAtelier}}</td>
                                <td>{{$model->getListeAteliers()[$index]->HeureDebut}}</td>
                                <td>{{$model->getListeAteliers()[$index]->NombreDePlace}}</td>
                                <td>
                                    <button type="button" class="btnParticipation btn btn-danger" onclick="ouvrirModalSupprimer({{$model->getListeAteliers()[$index]->id}})" title="Annuler cet atelier" data-toggle="modal" data-target="#modalAnnulation" ><i class="fa fa-times"></i></button>
                                    <p id="descriptionAtelier{{$model->getListeAteliers()[$index]->id}}" hidden="hidden">{{$model->getListeAteliers()[$index]->Description}}</p>
                                                <button type="button" title="Voir la description de l'atelier." onclick="voirDescriptionAtelier('{{$model->getListeAteliers()[$index]->id}}')" data-toggle="modal" data-target="#modalVoirDescriptionAtelier" class="btn btn-primary"><i class="fa fa-eye"></i></button>
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalAnnulation" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="idTitreModal">Annulation d'un atelier</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-body" id="idContenu">
                    <p>Voulez-vous vraiment supprimer cet atelier?</p>
                </div>
                <div class="modal-footer">
                    <input id="idAtelier" name="idAtelier" value="0" hidden />
                    <button data-toggle="modal" data-target="#modalSupprimer" id="BoutonSupprimer" onclick="annulationAtelier({{Session::get('idCompte')}})" class="btn btn-danger">Oui</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Non</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalVoirDescriptionAtelier" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="idTitreModal">Description de l'atelier</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="idContenuDescription">
            </div>
            <div class="modal-footer">
                <input id="idAtelier" name="idAtelier" value="0" hidden />
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="js/Utilisateur/VoirListeAnnulationAtelier.js"></script>
@endsection
