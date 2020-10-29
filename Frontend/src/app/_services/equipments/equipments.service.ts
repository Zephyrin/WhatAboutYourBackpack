import { EquipmentsHttpService } from './equipments-http.service';
import { FormBuilder } from '@angular/forms';
import { CService } from '@app/_services/iservice';
import { Equipment } from '@app/_model/equipment';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class EquipmentsService extends CService<Equipment> {
  private nbEnumLeft = 0;

  constructor(
    private h: EquipmentsHttpService
  ) {
    super(h, undefined);
  }

  public initEnums(): void {
    this.initEnumDone.next(true);
  }

  public create(): Equipment {
    return new Equipment(undefined);
  }

  public createCpy(value: Equipment): Equipment {
    return new Equipment(value);
  }

  public createFormBasedOn(formBuilder: FormBuilder, value: Equipment): void {
    this.form = formBuilder.group({
      id: [''],

    });
  }

  public getDisplay(name: string, value: Equipment): any {
    switch (name) {
      case 'id':
        return value[name];
      default:
        break;
    }
    return value[name];
  }
}
