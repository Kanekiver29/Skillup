<?php


it('resolves the staff resource views from safe directory names', function () {
    expect(view()->exists('staff.images.image'))->toBeTrue();
    expect(view()->exists('staff.videos.list'))->toBeTrue();
    expect(view()->exists('staff.powerpoint.list'))->toBeTrue();
});
