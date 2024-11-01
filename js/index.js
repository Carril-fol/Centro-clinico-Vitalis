function checkOccupation() {
    const occupation = document.getElementById("occupationSelect").value;
    const additionalInputs = document.getElementById("additionalInputs");

    additionalInputs.innerHTML = ''

    switch (occupation) {
        case 'Medico':
            additionalInputs.innerHTML = `
                <div class="contenedor-opciones">
                    <input type="text" name="medicLicense" placeholder="Matricula" required/>
                    <select name="specialty">
                        <option value="Medico General">Médico General</option>
                        <option value="Enfermero">Enfermero</option>
                    </select>
                </div>
            `;
            break;
    }
}