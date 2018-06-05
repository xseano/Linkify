$(document).ready(
    () =>
    {

        $('#infoTab').on(
            'click', () =>
            {
                $('#linksTab').removeClass('is-active');
                $('#links').hide();

                $('#infoTab').addClass('is-active');
                $('#information').show();
            }
        );

        $('#linksTab').on(
            'click', () =>
            {
                $('#infoTab').removeClass('is-active');
                $('#information').hide();

                $('#linksTab').addClass('is-active');
                $('#links').show();
            }
        );

    }
);
