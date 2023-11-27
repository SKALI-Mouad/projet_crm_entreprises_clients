<template>
    <div class="login-box">

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Connecter-vous</p>
                <form @submit.prevent="soumettre" >
                    <div class="input-group mb-3">
                        <input
                            type="email"
                            class="form-control"
                            placeholder="E-mail"
                            v-model="form.email"
                            :class="{'is-invalid': form.errors.email}" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span v-if="form.errors.email" class="invalid-feedback error"> {{ form.errors.email }} </span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input
                            type="password"
                            class="form-control"
                            placeholder="Mot de passe"
                            v-model="form.password"
                            :class="{'is-invalid': form.errors.password}" required/>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div style="width:100%">
                            <button type="submit" class="btn btn-primary" style="width:100%">
                                Connexion
                            </button>
                        </div>
                    </div>
                </form>
                

                
            </div>
        </div>
    </div>
</template>

<script>
    import AuthLayout from "../Layouts/AuthLayout";
    export default {
        layout: AuthLayout
    }
</script>

<script setup>
    import { useForm } from "@inertiajs/vue3";
    import {useSwalError} from "../Composables/alert";

    const form = useForm({
    email: "",
    password: ""
    })

    const soumettre = ()=> (
        form.post(route("login"), {
            onError: (errors) => {
                console.log(errors.email);
                useSwalError("Une erreur s'est produite, reessayer");

            }
        })
    )
</script>
