export class Errors {
  errors: [];
  has: boolean;
  constructor(errors: []) {
    this.errors = errors;
    this.has = (this.errors !== undefined);
  }

  add(errors: []) {
    if (this.has) {
      if (errors !== undefined) {
        errors.forEach(value => {
          this.errors.push(value);
        });
      }
    }
    this.has = this.errors !== undefined;
  }
}
export class FormErrors {
  errors: Errors[];
  hasErrors: boolean[];
  hasAtLeastOne: boolean;
  message: string;
  hasMessage: boolean;
  fatalError: string;
  hasFatalError: boolean;
  error: any;

  constructor() {
    this.errors = [];
    this.hasErrors = [];
    this.hasMessage = this.hasFatalError = false;
    this.hasAtLeastOne = false;
  }

  formatError(error, controls = null) {
    this.message = error.error?.message;
    this.hasMessage = this.message !== undefined;
    this.errors = [];
    this.hasErrors = [];
    this.hasAtLeastOne = false;
    this.hasFatalError = false;
    this.fatalError = undefined;
    if (error.status === 500) {
      this.hasFatalError = true;
      this.fatalError = '... :S Internal server error.<br /><br/>'
        + 'We will take a look very soon ou pas.'
        + 'You can try again in some hours.<br/><br/>'
        + 'If it will still show this error consider to sent an email to:<br/>'
        + 'cametonneraisquejereponde@gmail.com';
    } else if (error.status === 404) {
      this.message = 'The resource is not on the server<br/>'
        + error.statusText + ' ' + error.url;
      this.hasMessage = this.message !== undefined;
    } else {
      this.hasFatalError = false;
      this.fatalError = undefined;
      if (error.error) {
        if (error.error.errors) {
          if (typeof error.error.errors === 'string') {
            this.errors[`errors`] = new Errors(error.error.errors);
          } else {
            error.error.errors.forEach(element => {
              Object.keys(element.children).forEach(key => {

                if (this.errors[key] === undefined) {
                  this.errors[key] = new Errors(element.children[key].errors);
                } else {
                  this.errors[key].add(element.children[key].errors);
                }
              });
              if (element.errors) {
                Object.keys(element.errors).forEach(key => {
                  if (this.errors[`errors`] === undefined) {
                    this.errors[`errors`] = new Errors(element.errors);
                  } else {
                    this.error[`errors`].add(element.errors);
                  }
                });
              }
            });
          }
        }
      }
      Object.keys(this.errors).forEach(key => {
        this.hasErrors[key] = this.errors[key].has;
        if (this.hasErrors[key] === true) {
          this.hasAtLeastOne = true;
        }
        if (controls !== null && controls[key] && this.hasErrors[key]) {
          controls[key].status = 'INVALID';
        }
      });
    }
  }

  clearError(name) {
    if (this.errors[name] !== undefined) {
      this.errors[name] = undefined;
    }
    if (this.hasErrors[name] !== undefined) {
      this.hasErrors[name] = false;
    }
    let hasError = false;
    Object.keys(this.errors).forEach(key => {
      if (this.hasErrors[key]) {
        hasError = true;
      }
    });
    if (!hasError) {
      this.message = undefined;
      this.hasMessage = false;
    }
  }

  get(name: string = 'errors') {
    if (this.hasErrors[name]) {
      return this.errors[name].errors[0];
    }
    return undefined;
  }
}
