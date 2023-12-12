<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/style.css">
    <title>SwitchBook - Registro</title>
</head>

<body background="public/media/fonlog.jpg" class="site-body">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-5">
                <div class="card custom-card">
                    <div class="card-header custom-header">
                        <h3 class="text-center custom-title">Registro</h3>
                    </div>
                    <div class="card-body">

                        <form action="./add_register.php" method="POST" class="row">



                            <div class="form-group">

                                <input type="name" name="nombre" class="form-control custom-input" required
                                    placeholder="Nombre">
                            </div>


                            <div class="form-group">

                                <input type="lastname" name="apellido" class="form-control custom-input" required
                                    placeholder="Apellidos">
                            </div>

                            
                            <div class="form-group">

                                <input type="date" max="2007-12-12" name="fecha_nacimiento"
                                    class="form-control custom-input" required placeholder="Fecha de nacimiento">
                            </div>


                            <div class="form-group">

                                <input type="email" name="correo_electronico" maxlength="100"
                                    class="form-control custom-input" required placeholder="Correo Electrónico">
                            </div>


                            <div class="form-group">

                                <input type="password" name="contrasena" minlength="6" class="form-control custom-input"
                                    required placeholder="Contraseña">
                            </div>


                            <div class="form-group">

                                <input type="password" name="confirmar_contrasena" minlength="6"
                                    class="form-control custom-input" required placeholder="Confirma Contraseña">
                            </div>


                            <div class="form-group">

                                <input type="text" name="telefono" maxlength="15" class="form-control custom-input"
                                    placeholder="Telefono">
                            </div>


                            <div class="form-group">

                                <label for="estado_pais">Selecciona tu estado:</label>
                                <select id="estado_pais" name="estado_pais" class="form-control custom-input" required
                                    aria-placeholder="uwu">
                                    <option value="Aguascalientes">Aguascalientes</option>
                                    <option value="Baja California">Baja California</option>
                                    <option value="Baja California Sur">Baja California Sur</option>
                                    <option value="Campeche">Campeche</option>
                                    <option value="Chiapas">Chiapas</option>
                                    <option value="Chihuahua">Chihuahua</option>
                                    <option value="Coahuila">Coahuila</option>
                                    <option value="Colima">Colima</option>
                                    <option value="Durango">Durango</option>
                                    <option value="Guanajuato">Guanajuato</option>
                                    <option value="Guerrero">Guerrero</option>
                                    <option value="Hidalgo">Hidalgo</option>
                                    <option value="Jalisco">Jalisco</option>
                                    <option value="México">México</option>
                                    <option value="Michoacán">Michoacán</option>
                                    <option value="Morelos">Morelos</option>
                                    <option value="Nayarit">Nayarit</option>
                                    <option value="Nuevo León">Nuevo León</option>
                                    <option value="Oaxaca">Oaxaca</option>
                                    <option value="Puebla">Puebla</option>
                                    <option value="Querétaro">Querétaro</option>
                                    <option value="Quintana Roo">Quintana Roo</option>
                                    <option value="San Luis Potosí">San Luis Potosí</option>
                                    <option value="Sinaloa">Sinaloa</option>
                                    <option value="Sonora">Sonora</option>
                                    <option value="Tabasco">Tabasco</option>
                                    <option value="Tamaulipas">Tamaulipas</option>
                                    <option value="Tlaxcala">Tlaxcala</option>
                                    <option value="Veracruz">Veracruz</option>
                                    <option value="Yucatán">Yucatán</option>
                                    <option value="Zacatecas">Zacatecas</option>

                                </select>
                            </div>


                            <div class="form-group">

                                <label for="genero">Selecciona tu género:</label>
                                <select name="genero" class="form-control custom-input" required>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>

                                </select>
                            </div>


                            <button type="submit" name="registrarme"
                                class="btn btn-primary custom-btn">Registrarme</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>



</body>

</html>