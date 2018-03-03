<?php

return [
    // Array de precio, cada posición del array representa la cantidad de clases por semana a la que asiste.
    // Ej:  0   ->    0 clases   =>   0$
    //      1   ->    1 clase    =>   250$
    'PRECIO_CLASES' => [0, 250, 500, 700, 850, 900],
    // Cantidad de minutos previos a una clase para que el alumno ya no pueda confirmar asistencia
    'MINUTOS_LIMITE_CONFIRMACION' => 60
];