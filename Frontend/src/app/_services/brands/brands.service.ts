import { FormBuilder, Validators } from '@angular/forms';
import { BrandsHttpService } from './brands-http.service';
import { Brand } from '@app/_model/brand';
import { CService } from '@app/_services/iservice';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class BrandsService extends CService<Brand> {
  private nbEnumLeft = 0;

  constructor(
    private h: BrandsHttpService
  ) {
    super(h, undefined);
  }

  public initEnums(): void {
    if (this.headers.length === 0) {
      this.headers.push({ value: 'name', viewValue: 'Nom' });
      this.headers.push({ value: 'uri', viewValue: 'Adresse' });
      this.displayedColumns.push('name');
      this.displayedColumns.push('uri');
    }
    this.initEnumDone.next(true);
  }

  public create(): Brand {
    return new Brand(undefined);
  }

  public createCpy(value: Brand): Brand {
    return new Brand(value);
  }

  public createFormBasedOn(formBuilder: FormBuilder, value: Brand): void {
    this.form = formBuilder.group({
      id: [''],
      name: ['', Validators.required],
      uri: ['']
    });
  }

  public getDisplay(name: string, value: Brand): any {
    switch (name) {
      case 'id':
        return value[name];
      case 'name':
        return value[name];
      default:
        break;
    }
    return value[name];
  }
}
