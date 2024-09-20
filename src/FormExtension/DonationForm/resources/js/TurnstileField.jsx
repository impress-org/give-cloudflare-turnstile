import {Turnstile} from '@marsidev/react-turnstile';
import {useEffect, useRef} from 'react';

export default function TurnstileField({
                                         Label,
                                         ErrorMessage,
                                         fieldError,
                                         inputProps
                                       }) {
  const ref = useRef();
  const { setValue} = window.givewp.form.hooks.useFormContext();
  const {submitCount} = window.givewp.form.hooks.useFormState();

  useEffect(() => {
    ref.current?.reset();
  }, [submitCount]);

  return (
    <>
      <label className={fieldError && 'givewp-field-error-label'}>

        <Label />

        <Turnstile
          ref={ref}
          siteKey={window.giveTurnstileFieldSettings.siteKey}
          onError={() => console.log('error')}
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
