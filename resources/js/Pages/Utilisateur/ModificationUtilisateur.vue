<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1 class="m-0">Formulaire d'ajout d'un nouveau employé</h1> -->
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                Edition de l'employé " {{ employe.nom_employe }} {{ employe.prenom_employe }} "
                            </h3>
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="soumettre" id="formulaireModificationEmploye">

                                <div class="form-group">
                                    <label for="">
                                        Nom :
                                    </label>
                                    <input type="text" class="form-control" placeholder="" v-model="form.nom_employe" :class="{'is-invalid': form.errors.nom_employe}" required>
                                    <span v-if="form.errors.nom_employe" class="invalid-feedback error"> Veuillez renseigner le nom </span>
                                </div>

                                <div class="form-group">
                                    <label for="">
                                        Prénom :
                                    </label>
                                    <input type="text" class="form-control" placeholder="" v-model="form.prenom_employe" :class="{'is-invalid': form.errors.prenom_employe}" required>
                                    <span v-if="form.errors.prenom_employe" class="invalid-feedback error"> Veuillez renseigner le prénom </span>
                                </div>

                                <div class="form-group">
                                    <label for="">
                                        Sexe :
                                    </label>
                                    <select class="form-control" v-model="form.sexe_employe" :class="{'is-invalid': form.errors.sexe_employe}">
                                        <option value="" selected>Choix sexe</option>
                                        <option value="Masculin">Masculin</option>
                                        <option value="Feminin">Feminin</option>
                                    </select>
                                    <span v-if="form.errors.sexe_employe" class="invalid-feedback error"> {{ form.errors.sexe_employe }} </span>
                                </div>

                                <div class="form-group">
                                    <label for="">
                                        Numéro téléphone :
                                    </label>
                                    <input type="number" class="form-control" placeholder="" v-model="form.numero_telephone_employe" :class="{'is-invalid': form.errors.numero_telephone_employe}">
                                    <span v-if="form.errors.numero_telephone_employe" class="invalid-feedback error"> {{ form.errors.numero_telephone_employe }} </span>
                                </div>

                                <div class="form-group">
                                    <label for="">
                                        E-mail :
                                    </label>
                                    <input type="email" class="form-control" placeholder="" v-model="form.email_employe" :class="{'is-invalid': form.errors.email_employe}" required>
                                    <span v-if="form.errors.email_employe" class="invalid-feedback error"> {{ form.errors.email_employe }} </span>
                                </div>

                                <div class="form-group">
                                    <label for="">
                                        Mot de passe :
                                    </label>
                                    <input type="text" class="form-control" placeholder="Remplissez pour changer votre mot de passe" v-model="form.mdp" :class="{'is-invalid': form.errors.mdp}">
                                    <span v-if="form.errors.mdp" class="invalid-feedback error"> {{ form.errors.mdp }} </span>
                                </div>

                                <div class="form-group">
                                    <label for="">
                                        Entreprise :
                                    </label>
                                    <select class="form-control" v-model="form.id" :class="{'is-invalid': form.errors.id}" required>
                                        <option value="" selected>Choix sexe</option>
                                        <option :value="entreprise.id" :key="entreprise.id" v-for="entreprise in props.entreprises">
                                            {{ entreprise.nom_entreprise }}
                                        </option>   
                                    </select>
                                    <span v-if="form.errors.id" class="invalid-feedback error"> Veuillez renseigner l'entreprise </span>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <div class="form-group">
                                        <label for="">
                                            Photo de profile :
                                        </label>
                                        <input :key="inputKey" type="file" accept="image/*" class="form-control" placeholder="" @input="previwImage($event)">
                                    </div>
                                    <div v-if="employe.photo_employe">
                                        <img :src="'/storage/'+employe.photo_employe" id="image-preview" style="width: 75px; height: 75px; border-radius: 25px;">
                                    </div>
                                    <div v-else>
                                        <img src="/images/image_de_base.jpeg" id="image-preview" style="width: 75px; height: 75px; border-radius: 25px;">
                                    </div>
                                </div>  

                            </form>
                        </div>
                        <div class="card-footer">
                            <button form="formulaireModificationEmploye" type="submit" class="btn btn-success">Soumettre</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import MainLayoutUtilisateur from "../../Layouts/MainLayoutUtilisateur.vue";
    export default {
        layout: MainLayoutUtilisateur
    }
</script>

<script setup>

import { useForm } from "@inertiajs/vue3";
import {useSwalSuccess, useSwalError} from "../../Composables/alert";
import {router} from "@inertiajs/vue3";
import {ref} from "vue";

const props = defineProps({
        entreprises: Array,
        employe: Object
    })


const inputKey = ref(0);

const form = useForm({
    nom_employe: props.employe.nom_employe,
    prenom_employe: props.employe.prenom_employe,
    sexe_employe: props.employe.sexe_employe,
    numero_telephone_employe: props.employe.numero_telephone_employe,
    email_employe: props.employe.email_employe,
    mdp: props.employe.mdp,
    id: props.employe.entreprise_id,
    photo_employe: null,
})

//console.log("form : ", form);

const previwImage = (event)=> {
    let files_cont = event.target.files.lenght;
    if (event.target.files.lenght != 0) {
        form.photo_employe = event.target.files[0];
        var src = URL.createObjectURL(event.target.files[0]);
        var previwImage = document.getElementById("image-preview");
        previwImage.src = src;
        previwImage.style.display = "block";
    }
};

const soumettre = ()=> {
    console.log("logs :", form);
    form.post(route("utilisateur.update", { employe: props.employe}), {
        onSuccess: (page) => {
                useSwalSuccess("Employé mis à jour avec succès");
            },
            onError: (errors) => {
                //console.log(errors);
                useSwalError("Une erreur s'est produite, reessayer");

            }
    })
};

</script>
