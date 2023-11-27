@component('mail::message')
   
<p> Bonjour {{ $user->name }}, </p>
<p>Vous avez été invité à rejoindre la plateforme de gestion des employés. </p>
<p>Ici vous trouvez votre information de login :</p>
E-mail : {{ $user->email }} <br />
Mot de passe : password <br /> <br />
<p>Veuillez vérifier vos données en cliquant sur ce button : </p>

@component('mail::button', ['url' => url('verify/'.$user->remember_token)])
Confirmer 
@endcomponent

<p>Si vous rencontez un problème, prière de nous contacter.</p>
Bonne journée, Tersea projet <br />
@endcomponent