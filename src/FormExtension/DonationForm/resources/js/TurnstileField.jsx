import {Turnstile} from '@marsidev/react-turnstile';
import {__} from '@wordpress/i18n';
import {useEffect, useRef, useCallback} from 'react';

export default function TurnstileField({
                                         Label,
                                         ErrorMessage,
                                         fieldError,
                                         inputProps
                                       }) {
  const ref = useRef();
  const { setValue, setError } = window.givewp.form.hooks.useFormContext();
  const { submitCount } = window.givewp.form.hooks.useFormState();
  const setFormError = useCallback(() =>
    setError('FORM_ERROR', {
      message: __('You must be a human.', 'give')
    }), [setError]
  );

  useEffect(() => {
    if (fieldError && fieldError !== 'This is a required field') {
      setFormError();
    }
  }, [fieldError]);

  useEffect(() => {
    ref.current?.reset();
  }, [submitCount]);

  return (
    <>
      <label className={fieldError && 'givewp-field-error-label'}>

        {/*<Label />*/}

        <Turnstile
          ref={ref}
          siteKey={window.giveTurnstileFieldSettings.siteKey}
          onError={() => {
              console.log('error');
              setFormError();
            }
          }
          onExpire={() => ref.current?.reset()}
          onSuccess={value => {
            console.log('success');
            setValue(inputProps.name, value);
          }}
        />

        <input type="hidden" {...inputProps} />

        <ErrorMessage />
      </label>
    </>
  );
}
