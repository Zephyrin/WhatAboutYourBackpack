import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { EquipmentsDesktopComponent } from './equipments-desktop.component';

describe('EquipmentsDesktopComponent', () => {
  let component: EquipmentsDesktopComponent;
  let fixture: ComponentFixture<EquipmentsDesktopComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EquipmentsDesktopComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(EquipmentsDesktopComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
