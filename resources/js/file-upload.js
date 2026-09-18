import * as FilePond from 'filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import nl from 'filepond/locale/nl-nl.js';

/**
 * Maakt van elk .file-upload-veld een FilePond. Met storeAsFile zet FilePond de
 * bestanden terug in het gewone invoerveld, zodat ze met het formulier als
 * normale upload meegaan (zie submit-form.js). Geen base64 en geen aparte
 * uploadroute: de server controleert het echte bestand.
 *
 * De toegestane typen komen uit het accept-attribuut van het veld. Het type en
 * de grootte controleren we hier alleen voor het gemak van de bezoeker; de
 * regels die tellen staan in SubmitApplication.
 */
const inputs = document.querySelectorAll('input.file-upload');

if(inputs.length) {
    FilePond.registerPlugin(FilePondPluginFileValidateType, FilePondPluginFileValidateSize);

    inputs.forEach((input) => {
        FilePond.create(input, {
            ...nl,
            storeAsFile:                           true,
            allowMultiple:                         true,
            maxFiles:                              Number(input.dataset.maxFiles) || null,
            maxFileSize:                           input.dataset.maxFileSize || null,
            credits:                               false,
            fileValidateTypeLabelExpectedTypesMap: {
                'application/pdf':                                                         '.pdf',
                'application/msword':                                                      '.doc',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document': '.docx',
                'image/jpeg':                                                              '.jpg',
                'image/png':                                                               '.png',
            },
            labelIdle:                             'Sleep je cv en motivatie hierheen of <span class="filepond--label-action">kies bestanden</span>',
            labelFileTypeNotAllowed:               'Dit bestandstype kan niet',
            fileValidateTypeLabelExpectedTypes:    'Kies een {allButLastType} of {lastType}',
            labelMaxFileSizeExceeded:              'Bestand is te groot',
            labelMaxFileSize:                      'Maximaal {filesize}',
        });
    });
}
