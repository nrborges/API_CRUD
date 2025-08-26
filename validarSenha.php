<?php
function validarSenha($senha) {
    // mínimo 8 caracteres, pelo menos 1 maiúscula e 1 especial
    return preg_match('/^(?=.*[A-Z])(?=.*[!@#$%&*?]).{8,}$/', $senha);
}
?>