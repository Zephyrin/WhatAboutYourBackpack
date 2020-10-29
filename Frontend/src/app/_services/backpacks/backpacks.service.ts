import { FormBuilder } from '@angular/forms';
import { BackpacksHttpService } from './backpacks-http.service';
import { CService } from '@app/_services/iservice';
import { Injectable } from '@angular/core';
import { Backpack } from '@app/_model/backpack';

@Injectable({
  providedIn: 'root'
})
export class BackpacksService extends CService<Backpack> {

  private nbEnumLeft = 0;

  constructor(
    private h: BackpacksHttpService
  ) {
    super(h, undefined);
  }

  public initEnums(): void {
    this.initEnumDone.next(true);
  }

  public create(): Backpack {
    return new Backpack(undefined);
  }

  public createCpy(backpack: Backpack): Backpack {
    return new Backpack(backpack);
  }

  public createFormBasedOn(formBuilder: FormBuilder, value: Backpack): void {
    this.form = formBuilder.group({
      id: [''],

    });
  }

  public getDisplay(name: string, value: Backpack): any {
    switch (name) {
      case 'id':
        return value[name];
      default:
        break;
    }
    return value[name];
  }
}
