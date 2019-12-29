@extends ('Shared/Master_Layout')

@section ('styles')
<!-- Styles -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="css/Administrateur/VoirCreationAtelier.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
@endsection

@section ('content')
<!-- Contenu -->

<div class="col-md-12">
    <div class="card">
        <form action="/Atelier/CreerAtelier" method="post">
            @csrf
            <div id="contact-form" class="form-container" data-form-container>
                <div class="row">
                    <div class="form-title">
                        <div id="titre">Ajouter un nouvel atelier</div>
                    </div>
                </div>
                <div class="row">
                    <table id="tableauErreurs">
                        @foreach ($errors->all() as $message)
                        <tr>
                            <td align="left"><label class="erreur">{{$message}}</label></td>
                        </tr>

                        @endforeach
                    </table>

                </div>
                <div class="input-container">
                    <div class="row">
                        <span class="req-input" >
                            <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer le nom de l'atelier."> </span>
                            <input type="text" name="Nom" value='{{ old('Nom') }}' data-min-length="1" placeholder="Nom">
                        </span>
                    </div>
                    <div class="row">
                        <span class="req-input" >
                            <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer le nom de l'endroit où se déroulera l'activité."> </span>
                            <input type="text" name="Endroit" value='{{ old('Endroit') }}' data-min-length="1" placeholder="Localisation">
                        </span>
                    </div>
                    <div class="row">
                        <span class="req-input" >
                            <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer l'heure à laquelle l'activité débutera."> </span>
                            <input type="time" name="HeureDebut" value='{{ old('HeureDebut') }}' data-min-length="1" placeholder="Heure de début">
                        </span>
                    </div>
                    <div class="row">
                        <span id="duree" class="req-input" >
                            <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer la durée de l'activité en heure."> </span>
                            <input type="text" name="Duree" value='{{ old('Duree') }}' data-min-length="1" placeholder="Durée">
                        </span>
                    </div>
                    <div class="row">
                        <span id="description" class="req-input" >
                            <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer la description de l'atelier."> </span>
                            <textarea type="text" name='Description' maxlength="10000" placeholder="Description" rows="10">{{old('Description')}}</textarea>
                        </span>
                    </div>
                    <div class="row">
                        <span class="req-input" >
                            <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer la date où se déroulera l'atelier."> </span>
                            <input type="date" name="DateAtelier" value='{{ old('DateAtelier') }}' placeholder="Date">
                        </span>
                    </div>
                    <div class="row">
                        <span class="req-input" >
                            <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez entrer le nombre maximal de participants."> </span>
                            <input id='nombreDePlaces' type="number" name="NombreDePlace" value='{{ old('NombreDePlace') }}' min="1" data-min-length="1" placeholder="Nombre de places disponibles">
                        </span>
                    </div>
                    <div class="row">
                        <span class="req-input" >
                            <span class="input-status" data-toggle="tooltip" data-placement="top" title="Veuillez sélectionner le ou les campus où se déroulera l'atelier."> </span>
                            <select id="selectCampus" name="idCampus">
                                <option value="1">Tous les campus</option>
                                <option value="2">Gabrielle-Roy</option>
                                <option value="2">Félix-Leclerc</option>
                            </select>
                        </span>
                    </div>
                    <div class="row submit-row">
                        <button type="submit" class="btn btn-block submit-form">Soumettre</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="js/Administrateur/VoirCreationAtelier.js"></script>

@endsection
