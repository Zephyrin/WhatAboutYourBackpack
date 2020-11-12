import { EquipmentsHttpService } from './equipments-http.service';
import { FormBuilder, Validators, FormGroup } from '@angular/forms';
import { CService } from '@app/_services/iservice';
import { Equipment, Characteristic } from '@app/_model/equipment';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class EquipmentsService extends CService<Equipment> {
  private nbEnumLeft = 0;
  characteristicForm: FormGroup;
  addCharacteristic = false;
  updateCharacteristic = false;
  constructor(
    private h: EquipmentsHttpService
  ) {
    super(h, undefined);
  }

  public initEnums(): void {
    if (this.headers.length === 0) {
      this.headers.push({ value: 'name', viewValue: 'Nom' });
      this.headers.push({ value: 'brand', viewValue: 'Marque' });
      this.headers.push({ value: 'price', viewValue: 'Prix' });
      this.headers.push({ value: 'weight', viewValue: 'Poids' });

      this.displayedColumns.push('name');
      this.displayedColumns.push('brand');
      this.displayedColumns.push('price');
      this.displayedColumns.push('weight');
    }
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
      name: ['', Validators.required],
      category: ['', Validators.required],
      brand: ['', Validators.required]
    });
  }

  public getDisplay(name: string, value: Equipment): any {
    switch (name) {
      case 'id':
        return value[name];
      case 'brand':
        return value[name]?.name;
      case 'category':
        return value[name]?.name;
      case 'price':
        {
          const i = value.characteristics.findIndex(c => c.name === 'Prix');
          if (i >= 0) { return value.characteristics[i].value + ' ' + value.characteristics[i].unit; }
        }
        return '';
      case 'weight':
        {
          const i = value.characteristics.findIndex(c => c.name === 'Poids');
          if (i >= 0) { return value.characteristics[i].value + ' ' + value.characteristics[i].unit; }
        }
        return '';
      default:
        break;
    }
    return value[name];
  }

  public createFormCharacteristic(formBuilder: FormBuilder) {
    this.characteristicForm = formBuilder.group({
      id: [''],
      name: ['', Validators.required],
      value: ['', Validators.required],
      unit: ['']
    });
  }

  public addCharacteristicClick(equipment: Equipment) {
    this.updateCharacteristic = false;
    if (!this.addCharacteristic) {
      const chara = new Characteristic(undefined);
      chara.equipment = equipment;
      this.characteristicForm.reset(chara);
    }
    this.addCharacteristic = !this.addCharacteristic;
  }

  public updateCharacteristicsClick(equipment: Equipment) {
    this.addCharacteristic = false;
    this.updateCharacteristic = !this.updateCharacteristic;
    if (!this.updateCharacteristic) {
      this.characteristicForm.reset();
    }
  }

  public cancelCharacteristic() {
    this.characteristicForm.reset();
    this.addCharacteristic = false;
  }

  public isSameCharacteristicThanForm(chara: Characteristic): boolean {
    return this.characteristicForm.value?.id === chara.id;
  }

  public updateCharacteristicClick(equipment: Equipment, characteristic: Characteristic) {
    this.characteristicForm.patchValue(characteristic);
  }

  public updateCharacteristicSubmit(characteristic: Characteristic) {
    if (this.characteristicForm.valid) {
      const dataToSent = new Characteristic(this.characteristicForm.value);
      dataToSent.equipment = characteristic.equipment;
      (this.http as EquipmentsHttpService).updateCharacteristic(dataToSent).subscribe(newData => {
        characteristic.name = dataToSent.name;
        characteristic.value = dataToSent.value;
        characteristic.unit = dataToSent.unit;
        this.characteristicForm.reset();
        this.end(true);

      }, serverError => {
        this.endCharacteristicError(serverError);
      });
    }
  }
  public saveNewCharacteristic(equipment: Equipment) {
    if (this.characteristicForm.valid) {
      const dataToSent = new Characteristic(this.characteristicForm.value);
      dataToSent.equipment = equipment;
      (this.http as EquipmentsHttpService).addCharacteristic(dataToSent).subscribe(newData => {
        equipment.characteristics.push(new Characteristic(newData));
        this.addCharacteristic = false;
        this.end(true);
      }, serverError => {
        this.endCharacteristicError(serverError);
      });
    }
  }

  private endCharacteristicError(serverError: any) {
    this.errors.formatError(serverError);
    if (serverError.error?.errors) {
      serverError.error.errors.forEach(error => {
        Object.keys(error.children).forEach(prop => {
          const formControl = this.characteristicForm.get(prop);
          if (formControl && error.children[prop].errors) {
            // activate error message
            error.children[prop].errors.forEach(message => {
              formControl.setErrors({
                serverError: message
              });
            });
          }
        });
      });
    }
    this.end(true);
  }
}
