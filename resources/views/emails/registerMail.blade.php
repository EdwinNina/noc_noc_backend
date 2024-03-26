<style>
       h1 {
            font-size: 24px;
            margin-top: 0;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
        }

    .container {
        width: 600px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ddd;
    }

    .footer {
        text-align: center;
        margin-top: 20px;
    }
</style>
<div class="container">
    <h1>¡Bienvenid@!</h1>

    <p>Te damos la bienvenida {{ $username }} a nuestra aplicacion de tareas NocApp. Nos complace que te hayas registrado.</p>

    <p>Ahora puedes disfrutar de todo el trabajo con nosotros</p>

    <p>Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos.</p>

    <p>**Atentamente,**</p>

    <p>El equipo de {{ $team }}</p>
</div>

<div class="footer">
    <p>&copy; 2024 NOC NOC</p>
</div>
